@extends('layouts.app')

@section('title', 'Laporan Waiter')
@section('header', 'Laporan Waiter')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Waiter</h1>
        <p class="text-gray-600">Analisis performa waiter dan statistik pelayanan</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500" value="{{ now()->format('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Waiter</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>Semua Waiter</option>
                    @if(isset($waiterStats))
                        @foreach($waiterStats as $waiter)
                            <option>{{ $waiter->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors btn-hover">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-user-tie text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $waiterStats->count() ?? 0 }}</h3>
            <p class="text-sm text-gray-500">Total Waiter</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>Aktif hari ini</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-success-500 to-success-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-shopping-bag text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $waiterStats->sum('total_orders') ?? 0 }}</h3>
            <p class="text-sm text-gray-500">Total Orders</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>Periode ini</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-warning-500 to-warning-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($waiterStats->sum('total_nilai_order') ?? 0, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Total Nilai</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>Revenue waiter</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-danger-500 to-danger-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-warning-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-minus text-warning-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $waiterStats->avg('total_orders') ? round($waiterStats->avg('total_orders'), 1) : 0 }}</h3>
            <p class="text-sm text-gray-500">Rata-rata Order</p>
            <div class="mt-4 flex items-center text-xs text-warning-600">
                <i class="fas fa-minus mr-1"></i>
                <span>Per waiter</span>
            </div>
        </div>
    </div>

    <!-- Waiter Performance Table -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Performa Waiter</h3>
                <div class="flex space-x-2">
                    <button class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        <i class="fas fa-download mr-1"></i>
                        Export
                    </button>
                    <button class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                        <i class="fas fa-print mr-1"></i>
                        Print
                    </button>
                </div>
            </div>
        </div>
        <div class="p-6">
            @if(isset($waiterPerformance) && $waiterPerformance->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <th class="pb-3">Rank</th>
                                <th class="pb-3">Nama Waiter</th>
                                <th class="pb-3">Total Orders</th>
                                <th class="pb-3">Total Nilai</th>
                                <th class="pb-3">Rata-rata/Order</th>
                                <th class="pb-3">Performa</th>
                                <th class="pb-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($waiterStats as $index => $waiter)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="py-4">
                                        <div class="flex items-center justify-center">
                                            @if($index === 0)
                                                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-yellow-600">1</span>
                                                </div>
                                            @elseif($index === 1)
                                                <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-gray-600">2</span>
                                                </div>
                                            @elseif($index === 2)
                                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-bold text-orange-600">3</span>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 bg-gray-50 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-500">{{ $index + 1 }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-semibold text-white">{{ substr($waiter->name, 0, 2) }}</span>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $waiter->name }}</p>
                                                <p class="text-xs text-gray-500">Waiter</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-sm font-semibold text-gray-900">{{ $waiter->total_orders }}</span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format($waiter->total_nilai_order, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-4">
                                        <span class="text-sm text-gray-600">Rp. {{ number_format($waiter->total_orders > 0 ? $waiter->total_nilai_order / $waiter->total_orders : 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2 rounded-full" style="width: {{ min(100, ($waiter->total_orders / ($waiterStats->max('total_orders') ?: 1)) * 100) }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ round(($waiter->total_orders / ($waiterStats->max('total_orders') ?: 1)) * 100) }}%</span>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex space-x-2">
                                            <button class="text-primary-600 hover:text-primary-700 text-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-gray-600 hover:text-gray-700 text-sm">
                                                <i class="fas fa-chart-bar"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-tie text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500">Tidak ada data waiter</p>
                    <p class="text-sm text-gray-400 mt-1">Data performa waiter akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- Top Performers -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Top 3 Performers</h3>
            </div>
            <div class="p-6">
                @if(isset($waiterStats) && $waiterStats->count() > 0)
                    <div class="space-y-4">
                        @foreach($waiterStats->take(3) as $index => $waiter)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($index === 0)
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-trophy text-yellow-600"></i>
                                        </div>
                                    @elseif($index === 1)
                                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-medal text-gray-600"></i>
                                        </div>
                                    @elseif($index === 2)
                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-award text-orange-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $waiter->name }}</p>
                                        <span class="text-sm text-gray-600">{{ $waiter->total_orders }} orders</span>
                                    </div>
                                    <div class="bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-primary-500 to-primary-600 h-2 rounded-full" style="width: {{ min(100, ($waiter->total_orders / ($waiterStats->max('total_orders') ?: 1)) * 100) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Belum ada data performa</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Performance Distribution -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Distribusi Performa</h3>
            </div>
            <div class="p-6">
                <canvas id="performanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart');
    if (ctx && {{ isset($waiterStats) && $waiterStats->count() > 0 ? 'true' : 'false' }}) {
        const labels = @json(isset($waiterStats) ? $waiterStats->pluck('name')->toArray() : []);
        const data = @json(isset($waiterStats) ? $waiterStats->pluck('total_orders')->toArray() : []);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Orders',
                    data: data,
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
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
                                return 'Orders: ' + context.parsed.y;
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
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
