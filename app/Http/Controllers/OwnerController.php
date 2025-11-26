<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaksi;
use App\Models\Masakan;
use App\Models\User;
use App\Models\DetailOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OwnerController extends Controller
{
    public function test()
    {
        try {
            // Get same data as dashboard
            $totalRevenue = Transaksi::berhasil()->sum('total_bayar');
            $totalOrders = Order::count();
            $totalTransactions = Transaksi::berhasil()->count();
            $totalCustomers = User::whereHas('level', function($q) {
                $q->where('nama_level', 'Pelanggan');
            })->count();

            return view('owner.test', compact(
                'totalRevenue', 'totalOrders', 'totalTransactions', 'totalCustomers'
            ));
        } catch (\Exception $e) {
            Log::error('OwnerController::test error: ' . $e->getMessage());
            // Return with default values to prevent white screen
            return view('owner.test', [
                'totalRevenue' => 0,
                'totalOrders' => 0,
                'totalTransactions' => 0,
                'totalCustomers' => 0
            ]);
        }
    }

    public function dashboard()
    {
        try {
            // Debug: Log method call
            Log::info('OwnerController::dashboard called');
            
            // Total statistics
            $totalRevenue = Transaksi::berhasil()->sum('total_bayar');
            $totalOrders = Order::count();
            $totalTransactions = Transaksi::berhasil()->count();
            $totalCustomers = User::whereHas('level', function($q) {
                $q->where('nama_level', 'Pelanggan');
            })->count();

            // Today statistics
            $todayRevenue = Transaksi::whereDate('tanggal', today())->berhasil()->sum('total_bayar');
            $todayOrders = Order::whereDate('tanggal', today())->count();
            $todayTransactions = Transaksi::whereDate('tanggal', today())->berhasil()->count();

            // This month statistics
            $thisMonthRevenue = Transaksi::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->berhasil()->sum('total_bayar');
            $thisMonthOrders = Order::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->count();

            // Top selling items
            $topMasakan = DB::table('detail_orders')
                ->join('masakans', 'detail_orders.id_masakan', '=', 'masakans.id_masakan')
                ->select('masakans.nama_masakan', DB::raw('SUM(detail_orders.jumlah) as total_terjual'), DB::raw('SUM(detail_orders.subtotal) as total_pendapatan'))
                ->groupBy('masakans.id_masakan', 'masakans.nama_masakan')
                ->orderBy('total_terjual', 'desc')
                ->take(5)
                ->get();

            // Waiter performance
            $waiterPerformance = DB::table('orders')
                ->join('users', 'orders.id_user', '=', 'users.id')
                ->join('levels', 'users.id_level', '=', 'levels.id_level')
                ->where('levels.nama_level', 'Waiter')
                ->select('users.name', DB::raw('COUNT(orders.id_order) as total_orders'))
                ->groupBy('users.id', 'users.name')
                ->orderBy('total_orders', 'desc')
                ->take(5)
                ->get();

            // Recent transactions
            $recentTransactions = Transaksi::with(['order.user', 'order.meja'])
                ->orderBy('tanggal', 'desc')
                ->take(10)
                ->get();

            // Monthly revenue for chart (last 6 months)
            $monthlyRevenue = Transaksi::berhasil()
                ->select(DB::raw('MONTH(tanggal) as month'), DB::raw('YEAR(tanggal) as year'), DB::raw('SUM(total_bayar) as revenue'))
                ->where('tanggal', '>=', now()->subMonths(5))
                ->groupBy(DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)'))
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Debug: Log calculated values
            Log::info('Owner dashboard data calculated', [
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'totalTransactions' => $totalTransactions,
                'totalCustomers' => $totalCustomers,
                'todayRevenue' => $todayRevenue,
                'todayOrders' => $todayOrders,
                'todayTransactions' => $todayTransactions,
                'thisMonthRevenue' => $thisMonthRevenue,
                'thisMonthOrders' => $thisMonthOrders,
                'topMasakan_count' => $topMasakan->count(),
                'waiterPerformance_count' => $waiterPerformance->count(),
                'recentTransactions_count' => $recentTransactions->count(),
                'monthlyRevenue_count' => $monthlyRevenue->count()
            ]);

            return view('owner.dashboard', compact(
                'totalRevenue', 'totalOrders', 'totalTransactions', 'totalCustomers',
                'todayRevenue', 'todayOrders', 'todayTransactions',
                'thisMonthRevenue', 'thisMonthOrders',
                'topMasakan', 'waiterPerformance', 'recentTransactions', 'monthlyRevenue'
            ));
        } catch (\Exception $e) {
            Log::error('OwnerController::dashboard error: ' . $e->getMessage());
            // Return with default values to prevent white screen
            return view('owner.dashboard', [
                'totalRevenue' => 0,
                'totalOrders' => 0,
                'totalTransactions' => 0,
                'totalCustomers' => 0,
                'todayRevenue' => 0,
                'todayOrders' => 0,
                'todayTransactions' => 0,
                'thisMonthRevenue' => 0,
                'thisMonthOrders' => 0,
                'topMasakan' => collect([]),
                'waiterPerformance' => collect([]),
                'recentTransactions' => collect([]),
                'monthlyRevenue' => collect([])
            ]);
        }
    }

    public function laporanPenjualan()
    {
        try {
            $request = request();
            
            $start = $request->get('start', now()->startOfMonth()->format('Y-m-d'));
            $end = $request->get('end', now()->format('Y-m-d'));

            $transaksis = Transaksi::berhasil()
                ->whereBetween('tanggal', [$start, $end])
                ->with(['order.user', 'order.meja', 'order.detailOrders.masakan'])
                ->orderBy('tanggal', 'desc')
                ->get();

            $totalRevenue = $transaksis->sum('total_bayar');
            $totalTransactions = $transaksis->count();

            // Group by date for daily revenue
            $dailyRevenue = $transaksis->groupBy(function($transaksi) {
                return $transaksi->tanggal->format('Y-m-d');
            })->map(function($dayTransactions) {
                return $dayTransactions->sum('total_bayar');
            });

            return view('owner.laporan.penjualan', compact(
                'transaksis', 'totalRevenue', 'totalTransactions', 
                'dailyRevenue', 'start', 'end'
            ));
        } catch (\Exception $e) {
            Log::error('OwnerController::laporanPenjualan error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat laporan penjualan');
        }
    }

    public function laporanMasakan()
    {
        $request = request();
        
        $start = $request->get('start', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->get('end', now()->format('Y-m-d'));

        $masakanStats = DB::table('detail_orders')
            ->join('orders', 'detail_orders.id_order', '=', 'orders.id_order')
            ->join('masakans', 'detail_orders.id_masakan', '=', 'masakans.id_masakan')
            ->whereBetween('orders.tanggal', [$start, $end])
            ->select('masakans.nama_masakan', 'masakans.kategori', 
                DB::raw('SUM(detail_orders.jumlah) as total_terjual'),
                DB::raw('SUM(detail_orders.subtotal) as total_pendapatan'),
                DB::raw('COUNT(DISTINCT orders.id_order) as total_order'))
            ->groupBy('masakans.id_masakan', 'masakans.nama_masakan', 'masakans.kategori')
            ->orderBy('total_terjual', 'desc')
            ->get();

        $totalSold = $masakanStats->sum('total_terjual');
        $totalRevenue = $masakanStats->sum('total_pendapatan');

        return view('owner.laporan.masakan', compact(
            'masakanStats', 'totalSold', 'totalRevenue', 'start', 'end'
        ));
    }

    public function laporanWaiter()
    {
        $request = request();
        
        $start = $request->get('start', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->get('end', now()->format('Y-m-d'));

        $waiterStats = DB::table('orders')
            ->join('users', 'orders.id_user', '=', 'users.id')
            ->join('levels', 'users.id_level', '=', 'levels.id_level')
            ->where('levels.nama_level', 'Waiter')
            ->whereBetween('orders.tanggal', [$start, $end])
            ->select('users.name', 
                DB::raw('COUNT(orders.id_order) as total_orders'),
                DB::raw('SUM(orders.total_harga) as total_nilai_order'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_orders', 'desc')
            ->get();

        $totalOrders = $waiterStats->sum('total_orders');
        $totalValue = $waiterStats->sum('total_nilai_order');

        return view('owner.laporan.waiter', compact(
            'waiterStats', 'totalOrders', 'totalValue', 'start', 'end'
        ));
    }

    public function laporanPelanggan()
    {
        $request = request();
        
        $start = $request->get('start', now()->startOfMonth()->format('Y-m-d'));
        $end = $request->get('end', now()->format('Y-m-d'));

        // Since we don't have customer-specific orders, show transaction patterns
        $transactionStats = Transaksi::berhasil()
            ->whereBetween('tanggal', [$start, $end])
            ->select(DB::raw('DATE(tanggal) as date'), 
                DB::raw('COUNT(*) as total_transaksi'),
                DB::raw('SUM(total_bayar) as total_pendapatan'),
                DB::raw('AVG(total_bayar) as rata_rata_transaksi'))
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('date', 'desc')
            ->get();

        $totalTransactions = $transactionStats->sum('total_transaksi');
        $totalRevenue = $transactionStats->sum('total_pendapatan');
        $avgTransaction = $transactionStats->avg('rata_rata_transaksi');

        return view('owner.laporan.pelanggan', compact(
            'transactionStats', 'totalTransactions', 'totalRevenue', 'avgTransaction', 'start', 'end'
        ));
    }
}
