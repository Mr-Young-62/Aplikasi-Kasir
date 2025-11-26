<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaksi;
use App\Models\Masakan;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalTransaksi = Transaksi::where('status_transaksi', 'berhasil')->count();
        $totalMasakan = Masakan::count();
        $totalMeja = Meja::count();

        $todayOrders = Order::whereDate('tanggal', today())->count();
        $todayTransaksi = Transaksi::whereDate('tanggal', today())->where('status_transaksi', 'berhasil')->sum('total_bayar');

        $recentOrders = Order::with(['user', 'meja'])
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        $popularMasakan = DB::table('detail_orders')
            ->join('masakans', 'detail_orders.id_masakan', '=', 'masakans.id_masakan')
            ->select('masakans.nama_masakan', DB::raw('SUM(detail_orders.jumlah) as total_terjual'))
            ->groupBy('masakans.id_masakan', 'masakans.nama_masakan')
            ->orderBy('total_terjual', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalOrders', 
            'totalTransaksi', 
            'totalMasakan', 
            'totalMeja',
            'todayOrders',
            'todayTransaksi',
            'recentOrders',
            'popularMasakan'
        ));
    }
}
