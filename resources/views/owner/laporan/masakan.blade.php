@extends('layouts.app')

@section('title', 'Laporan Masakan')
@section('header', 'Laporan Masakan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Masakan</h1>
        <p class="text-gray-600">Analisis penjualan menu dan performa masakan</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form method="GET" action="{{ route('owner.laporan.masakan') }}" class="flex flex-col lg:flex-row gap-4">
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
                <a href="{{ route('owner.laporan.masakan') }}" 
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
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-utensils text-orange-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $masakanStats->count() }}</h3>
            <p class="text-sm text-gray-500">Total Menu Terjual</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Periode: {{ $start }} - {{ $end }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-green-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalSold }}</h3>
            <p class="text-sm text-gray-500">Total Terjual</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Semua menu</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Total Revenue</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Dari penjualan menu</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($totalSold > 0 ? $totalRevenue / $totalSold : 0, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Rata-rata Harga</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Per item terjual</span>
            </div>
        </div>
    </div>

    <!-- Top Selling Items & Category Distribution -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Items Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Top 5 Menu Terlaris</h3>
                <button onclick="exportChart('topItems')" class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            <div class="h-80">
                <canvas id="topItemsChart"></canvas>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Distribusi Kategori</h3>
                <button onclick="exportChart('category')" class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            <div class="h-80">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Menu Performance Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Performa Menu</h3>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Masakan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Terjual</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Revenue</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total Order</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata/Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Performa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($masakanStats as $index => $stat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-utensils text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $stat->nama_masakan }}</p>
                                        @if($index === 0)
                                            <p class="text-xs text-green-600">Terlaris</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    @switch($stat->kategori)
                                        @case('makanan')
                                            bg-orange-100 text-orange-800
                                            @break
                                        @case('minuman')
                                            bg-blue-100 text-blue-800
                                            @break
                                        @case('dessert')
                                            bg-pink-100 text-pink-800
                                            @break
                                        @default
                                            bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ ucfirst($stat->kategori) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold text-gray-900">{{ $stat->total_terjual }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format($stat->total_pendapatan, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-gray-900">{{ $stat->total_order }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm text-gray-900">Rp. {{ number_format($stat->total_order > 0 ? $stat->total_pendapatan / $stat->total_order : 0, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($stat->total_terjual / $totalSold) * 100) }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">{{ round(($stat->total_terjual / $totalSold) * 100, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-utensils text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Tidak ada data penjualan menu dalam periode ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Top Items Chart
    const topItemsCtx = document.getElementById('topItemsChart');
    if (topItemsCtx) {
        const masakanStats = @json($masakanStats->take(5));
        const labels = masakanStats.map(item => item.nama_masakan);
        const data = masakanStats.map(item => item.total_terjual);

        new Chart(topItemsCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Terjual',
                    data: data,
                    backgroundColor: [
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(168, 85, 247, 0.8)'
                    ],
                    borderWidth: 0,
                    borderRadius: 8,
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
                        callbacks: {
                            label: function(context) {
                                return 'Terjual: ' + context.parsed.y + ' items';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6',
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        const masakanStats = @json($masakanStats);
        const categoryData = {};
        
        masakanStats.forEach(item => {
            if (!categoryData[item.kategori]) {
                categoryData[item.kategori] = 0;
            }
            categoryData[item.kategori] += item.total_terjual;
        });

        const labels = Object.keys(categoryData);
        const data = Object.values(categoryData);

        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: labels.map(label => ucfirst(label)),
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(168, 85, 247, 0.8)'
                    ],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
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
    window.open('{{ route('owner.laporan.masakan') }}?export=excel&start={{ $start }}&end={{ $end }}', '_blank');
}

function printTable() {
    // Print functionality
    window.print();
}
</script>
@endsection
