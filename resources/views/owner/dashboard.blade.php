@extends('layouts.app')

@section('title', 'Owner Dashboard')
@section('header', 'Owner Dashboard')

@section('content')
<div class="animate-fade-in">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Overview</h1>
        <p class="text-gray-600">Monitor your restaurant performance and analytics</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue Card -->
        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Total Revenue</p>
            <div class="mt-4 flex items-center text-xs text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>12% from last month</span>
            </div>
        </div>

        <!-- Today's Revenue Card -->
        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-calendar-day text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Today's Revenue</p>
            <div class="mt-4 flex items-center text-xs text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>8% from yesterday</span>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-shopping-bag text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-down text-yellow-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalOrders ?? 0 }}</h3>
            <p class="text-sm text-gray-500">Total Orders</p>
            <div class="mt-4 flex items-center text-xs text-yellow-600">
                <i class="fas fa-arrow-down mr-1"></i>
                <span>3% from last week</span>
            </div>
        </div>

        <!-- Transactions Card -->
        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-credit-card text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalTransactions ?? 0 }}</h3>
            <p class="text-sm text-gray-500">Transactions</p>
            <div class="mt-4 flex items-center text-xs text-green-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>15% success rate</span>
            </div>
        </div>
    </div>

    <!-- Charts and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
                    <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                    </select>
                </div>
            </div>
            <div class="p-6">
                <canvas id="revenueChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Quick Stats</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-600">Customers</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $totalCustomers ?? 0 }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-utensils text-green-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-600">Menu Items</span>
                    </div>
                    <span class="font-semibold text-gray-900">8</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chair text-yellow-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-600">Tables</span>
                    </div>
                    <span class="font-semibold text-gray-900">12</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-tie text-red-600 text-sm"></i>
                        </div>
                        <span class="text-sm text-gray-600">Staff</span>
                    </div>
                    <span class="font-semibold text-gray-900">5</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Recent Transactions</h3>
                <a href="{{ route('owner.laporan.penjualan') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
            </div>
        </div>
        <div class="p-6">
            @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="pb-3">Transaction ID</th>
                                <th class="pb-3">Order</th>
                                <th class="pb-3">Date & Time</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Method</th>
                                <th class="pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentTransactions as $transaksi)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-3">
                                        <span class="text-sm font-medium text-gray-900">#{{ $transaksi->id_transaksi }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm text-gray-600">Order #{{ $transaksi->order->id_order ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y, H:i') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            {{ $transaksi->metode_pembayaran === 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($transaksi->metode_pembayaran ?? 'unknown') }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Success
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-receipt text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500">No transactions yet</p>
                    <p class="text-sm text-gray-400 mt-1">Transactions will appear here once they're made</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (ctx && {{ isset($monthlyRevenue) && $monthlyRevenue->count() > 0 ? 'true' : 'false' }}) {
        // Use real monthly revenue data
        const labels = @json(isset($monthlyRevenue) ? $monthlyRevenue->map(function($item) {
            return \Carbon\Carbon::createFromDate($item->year, $item->month, 1)->format('M Y');
        }) : []);
        const data = @json(isset($monthlyRevenue) ? $monthlyRevenue->pluck('revenue') : []);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: data,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: Rp. ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return 'Rp. ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection