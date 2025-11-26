<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\DetailOrder;
use App\Models\Masakan;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WaiterController extends Controller
{
    public function dashboard()
    {
        try {
            // Debug: Log method call
            Log::info('WaiterController::dashboard called for user: ' . auth()->id());
            
            $myOrders = Order::where('id_user', auth()->id())
                ->with(['meja', 'detailOrders.masakan'])
                ->orderBy('tanggal', 'desc')
                ->get();

            $pendingOrders = $myOrders->where('status_order', 'menunggu')->count();
            $processingOrders = $myOrders->where('status_order', 'diproses')->count();
            $completedOrders = $myOrders->where('status_order', 'selesai')->count();

            $availableMeja = Meja::tersedia()->get();
            $availableMasakan = Masakan::tersedia()->get();

            // Debug: Log calculated values
            Log::info('Waiter dashboard data calculated', [
                'user_id' => auth()->id(),
                'myOrders_count' => $myOrders->count(),
                'pendingOrders' => $pendingOrders,
                'processingOrders' => $processingOrders,
                'completedOrders' => $completedOrders,
                'availableMeja_count' => $availableMeja->count(),
                'availableMasakan_count' => $availableMasakan->count()
            ]);

            return view('waiter.dashboard', compact(
                'myOrders',
                'pendingOrders',
                'processingOrders', 
                'completedOrders',
                'availableMeja',
                'availableMasakan'
            ));
        } catch (\Exception $e) {
            Log::error('WaiterController::dashboard error: ' . $e->getMessage());
            // Return with default values to prevent white screen
            return view('waiter.dashboard', [
                'myOrders' => collect([]),
                'pendingOrders' => 0,
                'processingOrders' => 0,
                'completedOrders' => 0,
                'availableMeja' => collect([]),
                'availableMasakan' => collect([])
            ]);
        }
    }

    public function createOrder()
    {
        $availableMeja = Meja::tersedia()->get();
        $masakans = Masakan::tersedia()->get();

        return view('waiter.order.create', compact('availableMeja', 'masakans'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|exists:mejas,nomor_meja',
            'keterangan' => 'nullable|string',
            'items' => 'required|array',
            'items.*.id_masakan' => 'required|exists:masakans,id_masakan',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Update meja status
            $meja = Meja::where('nomor_meja', $request->nomor_meja)->first();
            $meja->update(['status_meja' => 'terisi']);

            // Create order
            $order = Order::create([
                'id_meja' => $meja->id_meja,
                'tanggal' => now(),
                'id_user' => auth()->id(),
                'keterangan' => $request->keterangan,
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

            return redirect()->route('waiter.dashboard')
                ->with('success', 'Order berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function editOrder($id_order)
    {
        $order = Order::where('id_user', auth()->id())
            ->where('id_order', $id_order)
            ->with(['detailOrders.masakan', 'meja'])
            ->firstOrFail();

        $masakans = Masakan::tersedia()->get();

        return view('waiter.order.edit', compact('order', 'masakans'));
    }

    public function updateOrder(Request $request, $id_order)
    {
        $order = Order::where('id_user', auth()->id())
            ->where('id_order', $id_order)
            ->firstOrFail();

        $request->validate([
            'status_order' => 'required|in:menunggu,diproses,selesai',
            'keterangan' => 'nullable|string',
        ]);

        $order->update([
            'status_order' => $request->status_order,
            'keterangan' => $request->keterangan,
        ]);

        // Update meja status if order is completed
        if ($request->status_order === 'selesai') {
            $order->meja->update(['status_meja' => 'tersedia']);
        }

        return redirect()->route('waiter.dashboard')
            ->with('success', 'Order berhasil diperbarui!');
    }

    public function addDetailOrder(Request $request, $id_order)
    {
        $request->validate([
            'id_masakan' => 'required|exists:masakans,id_masakan',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        $order = Order::where('id_user', auth()->id())
            ->where('id_order', $id_order)
            ->whereIn('status_order', ['menunggu', 'diproses'])
            ->firstOrFail();

        $masakan = Masakan::findOrFail($request->id_masakan);

        DetailOrder::create([
            'id_order' => $order->id_order,
            'id_masakan' => $request->id_masakan,
            'jumlah' => $request->jumlah,
            'harga_satuan' => $masakan->harga,
            'subtotal' => $masakan->harga * $request->jumlah,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Item berhasil ditambahkan ke order!');
    }

    public function removeDetailOrder($id_detail_order)
    {
        $detailOrder = DetailOrder::findOrFail($id_detail_order);
        $order = $detailOrder->order;

        // Check if order belongs to current user and is still editable
        if ($order->id_user !== auth()->id() || 
            !in_array($order->status_order, ['menunggu', 'diproses'])) {
            return back()->with('error', 'Tidak dapat menghapus item dari order ini!');
        }

        $detailOrder->delete();

        return back()->with('success', 'Item berhasil dihapus dari order!');
    }
}
