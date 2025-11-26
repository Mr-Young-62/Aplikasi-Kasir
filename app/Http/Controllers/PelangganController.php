<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masakan;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PelangganController extends Controller
{
    public function dashboard()
    {
        try {
            // Debug: Log method call
            Log::info('PelangganController::dashboard called for user: ' . auth()->id());
            
            $featuredMasakan = Masakan::tersedia()->take(8)->get();
            $categories = Masakan::select('kategori')->distinct()->pluck('kategori')->filter();

            // Debug: Log calculated values
            Log::info('Pelanggan dashboard data calculated', [
                'user_id' => auth()->id(),
                'featuredMasakan_count' => $featuredMasakan->count(),
                'categories_count' => $categories->count(),
                'categories' => $categories->toArray()
            ]);

            return view('pelanggan.dashboard', compact('featuredMasakan', 'categories'));
        } catch (\Exception $e) {
            Log::error('PelangganController::dashboard error: ' . $e->getMessage());
            // Return with default values to prevent white screen
            return view('pelanggan.dashboard', [
                'featuredMasakan' => collect([]),
                'categories' => collect([])
            ]);
        }
    }

    public function menu()
    {
        $categories = Masakan::select('kategori')->distinct()->pluck('kategori')->filter();
        $masakans = Masakan::tersedia()->paginate(12);

        return view('pelanggan.menu', compact('masakans', 'categories'));
    }

    public function menuByCategory($kategori)
    {
        $categories = Masakan::select('kategori')->distinct()->pluck('kategori')->filter();
        $masakans = Masakan::tersedia()->byKategori($kategori)->paginate(12);

        return view('pelanggan.menu', compact('masakans', 'categories', 'kategori'));
    }

    public function searchMenu(Request $request)
    {
        $search = $request->get('search');
        $categories = Masakan::select('kategori')->distinct()->pluck('kategori')->filter();
        
        $masakans = Masakan::tersedia()
            ->where(function($query) use ($search) {
                $query->where('nama_masakan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->paginate(12);

        return view('pelanggan.menu', compact('masakans', 'categories', 'search'));
    }

    public function showMenu($id_masakan)
    {
        $masakan = Masakan::findOrFail($id_masakan);
        $relatedMasakan = Masakan::tersedia()
            ->where('kategori', $masakan->kategori)
            ->where('id_masakan', '!=', $masakan->id_masakan)
            ->take(4)
            ->get();

        return view('pelanggan.menu-detail', compact('masakan', 'relatedMasakan'));
    }

    public function createSelfOrder()
    {
        $availableMeja = Meja::tersedia()->get();
        $masakans = Masakan::tersedia()->get();

        return view('pelanggan.order.create', compact('availableMeja', 'masakans'));
    }

    public function storeSelfOrder(Request $request)
    {
        $request->validate([
            'no_meja' => 'required|exists:mejas,no_meja',
            'keterangan' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id_masakan' => 'required|exists:masakans,id_masakan',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Update meja status
            $meja = Meja::where('no_meja', $request->no_meja)->first();
            $meja->update(['status_meja' => 'dipesan']);

            // Create order
            $order = Order::create([
                'no_meja' => $request->no_meja,
                'tanggal' => today(),
                'id_user' => auth()->id(),
                'keterangan' => $request->keterangan . ' (Self-Order)',
                'status_order' => 'menunggu',
            ]);

            // Create detail orders
            foreach ($request->items as $item) {
                $masakan = Masakan::findOrFail($item['id_masakan']);
                
                DetailOrder::create([
                    'id_order' => $order->id_order,
                    'id_masakan' => $item['id_masakan'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $masakan->harga,
                    'subtotal' => $masakan->harga * $item['jumlah'],
                    'keterangan' => $item['keterangan'] ?? null,
                ]);
            }

            // Calculate total
            $order->calculateTotal();

            DB::commit();

            return redirect()->route('pelanggan.order.show', $order->id_order)
                ->with('success', 'Order berhasil dibuat! Menunggu konfirmasi dari waiter.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showOrder($id_order)
    {
        $order = Order::where('id_user', auth()->id())
            ->with(['detailOrders.masakan', 'meja', 'transaksi'])
            ->findOrFail($id_order);

        return view('pelanggan.order.show', compact('order'));
    }

    public function myOrders()
    {
        $orders = Order::where('id_user', auth()->id())
            ->with(['meja', 'detailOrders.masakan', 'transaksi'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('pelanggan.orders', compact('orders'));
    }

    public function cancelOrder($id_order)
    {
        $order = Order::where('id_user', auth()->id())
            ->where('status_order', 'menunggu')
            ->firstOrFail();

        DB::beginTransaction();
        try {
            // Update meja status
            $order->meja->update(['status_meja' => 'kosong']);
            
            // Update order status
            $order->update(['status_order' => 'dibatal']);

            DB::commit();

            return back()->with('success', 'Order berhasil dibatalkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan order!');
        }
    }
}
