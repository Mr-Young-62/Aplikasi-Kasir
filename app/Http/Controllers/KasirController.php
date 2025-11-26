<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaksi;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function dashboard()
    {
        $readyOrders = Order::where('status_order', 'selesai')
            ->with(['user', 'meja', 'detailOrders.masakan'])
            ->whereDoesntHave('transaksi')
            ->orderBy('tanggal', 'desc')
            ->get();

        $myTransaksi = Transaksi::where('id_user', auth()->id())
            ->with(['order.user', 'order.meja'])
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        $todayTransaksi = Transaksi::whereDate('tanggal', today())
            ->where('id_user', auth()->id())
            ->berhasil()
            ->sum('total_bayar');

        $todayCount = Transaksi::whereDate('tanggal', today())
            ->where('id_user', auth()->id())
            ->berhasil()
            ->count();

        return view('kasir.dashboard', compact(
            'readyOrders',
            'myTransaksi',
            'todayTransaksi',
            'todayCount'
        ));
    }

    public function createTransaksi($id_order)
    {
        $order = Order::where('status_order', 'selesai')
            ->whereDoesntHave('transaksi')
            ->with(['user', 'meja', 'detailOrders.masakan'])
            ->findOrFail($id_order);

        return view('kasir.transaksi.create', compact('order'));
    }

    public function storeTransaksi(Request $request, $id_order)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:cash,transfer,kartu,ewallet',
            'uang_bayar' => 'required|numeric|min:0',
            'no_referensi' => 'nullable|string|max:100',
        ]);

        $order = Order::findOrFail($id_order);

        if ($order->status_order !== 'selesai' || $order->transaksi) {
            return back()->with('error', 'Order tidak valid untuk transaksi!');
        }

        $total_bayar = $order->total_harga;

        if ($request->metode_pembayaran === 'cash' && $request->uang_bayar < $total_bayar) {
            return back()->with('error', 'Uang bayar tidak mencukupi!');
        }

        DB::beginTransaction();
        try {
            $transaksi = Transaksi::create([
                'id_user' => auth()->id(),
                'id_order' => $order->id_order,
                'tanggal' => today(),
                'total_bayar' => $total_bayar,
                'uang_bayar' => $request->uang_bayar,
                'kembalian' => $request->uang_bayar - $total_bayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'no_referensi' => $request->no_referensi,
                'status_transaksi' => 'berhasil',
            ]);

            DB::commit();

            return redirect()->route('kasir.transaksi.show', $transaksi->id_transaksi)
                ->with('success', 'Transaksi berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showTransaksi($id_transaksi)
    {
        $transaksi = Transaksi::where('id_user', auth()->id())
            ->with(['order.user', 'order.meja', 'order.detailOrders.masakan'])
            ->findOrFail($id_transaksi);

        return view('kasir.transaksi.show', compact('transaksi'));
    }

    public function printStruk($id_transaksi)
    {
        $transaksi = Transaksi::where('id_user', auth()->id())
            ->with(['order.user', 'order.meja', 'order.detailOrders.masakan'])
            ->findOrFail($id_transaksi);

        return view('kasir.transaksi.print', compact('transaksi'));
    }

    public function listOrders()
    {
        $orders = Order::with(['user', 'meja'])
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('kasir.orders.index', compact('orders'));
    }

    public function listTransaksi()
    {
        $transaksis = Transaksi::where('id_user', auth()->id())
            ->with(['order.user', 'order.meja'])
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('kasir.transaksi.index', compact('transaksis'));
    }

    public function cancelTransaksi($id_transaksi)
    {
        $transaksi = Transaksi::where('id_user', auth()->id())
            ->where('status_transaksi', 'berhasil')
            ->findOrFail($id_transaksi);

        DB::beginTransaction();
        try {
            $transaksi->update(['status_transaksi' => 'batal']);
            $transaksi->order->update(['status_order' => 'selesai']);

            DB::commit();

            return back()->with('success', 'Transaksi berhasil dibatalkan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan transaksi!');
        }
    }
}
