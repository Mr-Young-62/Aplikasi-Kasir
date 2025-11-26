@extends('layouts.app')

@section('title', 'Dashboard Owner')
@section('header', 'Dashboard Owner')

@section('content')
<div class="animate-fade-in">
    <!-- Debug Info -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <h3 class="text-sm font-semibold text-yellow-800 mb-2">Debug Information:</h3>
        <div class="text-xs text-yellow-700 space-y-1">
            <p>Total Revenue: {{ $totalRevenue ?? 'NULL' }}</p>
            <p>Today Revenue: {{ $todayRevenue ?? 'NULL' }}</p>
            <p>Total Orders: {{ $totalOrders ?? 'NULL' }}</p>
            <p>Total Transactions: {{ $totalTransactions ?? 'NULL' }}</p>
            <p>Total Customers: {{ $totalCustomers ?? 'NULL' }}</p>
            <p>Top Masakan Count: {{ isset($topMasakan) ? $topMasakan->count() : 'NULL' }}</p>
            <p>Waiter Performance Count: {{ isset($waiterPerformance) ? $waiterPerformance->count() : 'NULL' }}</p>
            <p>Recent Transactions Count: {{ isset($recentTransactions) ? $recentTransactions->count() : 'NULL' }}</p>
            <p>Monthly Revenue Count: {{ isset($monthlyRevenue) ? $monthlyRevenue->count() : 'NULL' }}</p>
        </div>
    </div>

    <!-- Simple Test Section -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Simple Data Test</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-semibold text-blue-800">Revenue</h3>
                <p class="text-2xl font-bold text-blue-600">Rp. {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-semibold text-green-800">Orders</h3>
                <p class="text-2xl font-bold text-green-600">{{ $totalOrders ?? 0 }}</p>
            </div>
            <div class="bg-yellow-50 p-4 rounded-lg">
                <h3 class="font-semibold text-yellow-800">Transactions</h3>
                <p class="text-2xl font-bold text-yellow-600">{{ $totalTransactions ?? 0 }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="font-semibold text-purple-800">Customers</h3>
                <p class="text-2xl font-bold text-purple-600">{{ $totalCustomers ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Raw Data Display -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Raw Data Check</h2>
        
        @if(isset($recentTransactions) && $recentTransactions->count() > 0)
            <h3 class="font-semibold text-gray-700 mb-2">Recent Transactions ({{ $recentTransactions->count() }}):</h3>
            <div class="space-y-2">
                @foreach($recentTransactions->take(3) as $transaksi)
                    <div class="bg-gray-50 p-3 rounded border">
                        <p><strong>ID:</strong> {{ $transaksi->id_transaksi }}</p>
                        <p><strong>Total:</strong> Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
                        <p><strong>Date:</strong> {{ $transaksi->tanggal->format('d M Y') }}</p>
                        <p><strong>Status:</strong> {{ $transaksi->status_transaksi }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-red-600">No recent transactions found!</p>
        @endif

        @if(isset($topMasakan) && $topMasakan->count() > 0)
            <h3 class="font-semibold text-gray-700 mb-2 mt-4">Top Masakan ({{ $topMasakan->count() }}):</h3>
            <div class="space-y-2">
                @foreach($topMasakan->take(3) as $masakan)
                    <div class="bg-gray-50 p-3 rounded border">
                        <p><strong>Name:</strong> {{ $masakan->nama_masakan }}</p>
                        <p><strong>Sold:</strong> {{ $masakan->total_terjual }}</p>
                        <p><strong>Revenue:</strong> Rp. {{ number_format($masakan->total_pendapatan, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-red-600 mt-4">No top masakan found!</p>
        @endif
    </div>
</div>
@endsection
