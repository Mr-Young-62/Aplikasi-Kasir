@extends('layouts.app')

@section('title', 'Laporan Waiter')
@section('header', 'Laporan Waiter')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Waiter</h1>
        <p class="text-gray-600">Analisis performa waiter dan statistik pelayanan</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form method="GET" action="{{ route('owner.laporan.waiter') }}" class="flex flex-col lg:flex-row gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" name="start" value="{{ $start }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" name="end" value="{{ $end }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex items-end space-x-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('owner.laporan.waiter') }}" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-tie text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $waiterStats->count() }}</h3>
            <p class="text-sm text-gray-500">Total Waiter</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Aktif dalam periode ini</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-green-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalOrders }}</h3>
            <p class="text-sm text-gray-500">Total Orders</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Dari semua waiter</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($totalValue, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Total Nilai Order</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Revenue dari waiter</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $waiterStats->avg('total_orders') ? round($waiterStats->avg('total_orders'), 1) : 0 }}</h3>
            <p class="text-sm text-gray-500">Rata-rata Order</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Per waiter</span>
            </div>
        </div>
    </div>

    <!-- Waiter Performance Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Performa Waiter</h3>
                <div class="flex space-x-2">
                    <button onclick="exportTable()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        <i class="fas fa-download mr-1"></i>Export
                    </button>
                    <button onclick="printTable()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                        <i class="fas fa-print mr-1"></i>Print
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rank</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Waiter</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total Orders</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Nilai</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata/Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Performa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($waiterStats as $index => $waiter)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
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
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-semibold text-blue-600">{{ substr($waiter->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $waiter->name }}</p>
                                        <p class="text-xs text-gray-500">Waiter</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold text-gray-900">{{ $waiter->total_orders }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format($waiter->total_nilai_order, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm text-gray-900">Rp. {{ number_format($waiter->total_orders > 0 ? $waiter->total_nilai_order / $waiter->total_orders : 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($waiter->total_orders / ($totalOrders ?: 1)) * 100) }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">{{ round(($waiter->total_orders / ($totalOrders ?: 1)) * 100, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-user-tie text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Tidak ada data waiter dalam periode ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- Top Performers -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top 3 Performers</h3>
                <button onclick="exportChart('top')" class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            @if($waiterStats->count() > 0)
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
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($waiter->total_orders / ($totalOrders ?: 1)) * 100) }}%"></div>
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

        <!-- Performance Distribution -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Distribusi Performa</h3>
                <button onclick="exportChart('distribution')" class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            <div class="h-80">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('performanceChart');
    if (ctx) {
        const waiterStats = @json($waiterStats);
        const labels = waiterStats.map(item => item.name);
        const data = waiterStats.map(item => item.total_orders);

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

function exportChart(type) {
    // Export chart functionality
    alert('Export ' + type + ' chart functionality would be implemented here');
}

function exportTable() {
    // Export table functionality
    window.open('{{ route('owner.laporan.waiter') }}?export=excel&start={{ $start }}&end={{ $end }}', '_blank');
}

function printTable() {
    // Print functionality
    window.print();
}
</script>
@endsection
