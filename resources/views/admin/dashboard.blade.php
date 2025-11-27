@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- MAIN DASHBOARD CONTENT -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600">System overview and management</p>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
        <!-- Users Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</h3>
            <p class="text-sm text-gray-600 mt-1">Users</p>
        </div>

        <!-- Orders Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-white text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</h3>
            <p class="text-sm text-gray-600 mt-1">Orders</p>
        </div>

        <!-- Transactions Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-credit-card text-white text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">Success</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $totalTransaksi }}</h3>
            <p class="text-sm text-gray-600 mt-1">Transactions</p>
        </div>

        <!-- Masakan Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-utensils text-white text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">Available</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $totalMasakan }}</h3>
            <p class="text-sm text-gray-600 mt-1">Menu Items</p>
        </div>

        <!-- Meja Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chair text-white text-xl"></i>
                </div>
                <span class="text-xs text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">{{ $totalMeja }}</h3>
            <p class="text-sm text-gray-600 mt-1">Tables</p>
        </div>
    </div>

    <!-- TODAY'S STATS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Today's Orders</p>
                    <h3 class="text-3xl font-bold mt-1">{{ $todayOrders }}</h3>
                    <p class="text-blue-100 text-xs mt-2">Orders placed today</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-day text-white text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Today's Revenue</p>
                    <h3 class="text-3xl font-bold mt-1">Rp. {{ number_format($todayTransaksi, 0, ',', '.') }}</h3>
                    <p class="text-green-100 text-xs mt-2">Revenue today</p>
                </div>
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-white text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- RECENT ORDERS TABLE -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Orders</h3>
        </div>
        <div class="p-6">
            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                                <th class="pb-3">Order ID</th>
                                <th class="pb-3">Table</th>
                                <th class="pb-3">User</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3">
                                        <span class="text-sm font-medium text-gray-900">#{{ $order->id_order }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm text-gray-600">{{ $order->meja?->nomor_meja ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm text-gray-600">{{ $order->user?->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                            {{ $order->status_order === 'selesai' ? 'bg-green-100 text-green-800' : 
                                               ($order->status_order === 'diproses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($order->status_order) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm text-gray-600">{{ $order->tanggal?->format('d M Y') ?? '-' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500">No recent orders</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
