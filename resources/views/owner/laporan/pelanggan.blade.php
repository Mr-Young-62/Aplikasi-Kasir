@extends('layouts.app')

@section('title', 'Laporan Pelanggan')
@section('header', 'Laporan Pelanggan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Pelanggan</h1>
        <p class="text-gray-600">Analisis pelanggan dan perilaku pembelian</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form method="GET" action="{{ route('owner.laporan.pelanggan') }}" class="flex flex-col lg:flex-row gap-4">
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
                <a href="{{ route('owner.laporan.pelanggan') }}" 
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
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalTransactions }}</h3>
            <p class="text-sm text-gray-500">Total Transaksi</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Dalam periode ini</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-bag text-green-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $transactionStats->count() }}</h3>
            <p class="text-sm text-gray-500">Hari Aktif</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Dengan transaksi</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ round($avgTransaction, 0) }}</h3>
            <p class="text-sm text-gray-500">Rata-rata Transaksi</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Per transaksi</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Total Pendapatan</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Dari semua transaksi</span>
            </div>
        </div>
    </div>

    <!-- Customer Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Daily Transactions -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Transaksi Harian</h3>
                <button onclick="exportChart('transactions')" class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            <div class="h-80">
                <canvas id="dailyTransactionsChart"></canvas>
            </div>
        </div>

        <!-- Revenue Analysis -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Analisis Pendapatan</h3>
                <button onclick="exportChart('revenue')" class="text-sm text-blue-600 hover:text-blue-700">
                    <i class="fas fa-download mr-1"></i>Export
                </button>
            </div>
            <div class="h-80">
                <canvas id="revenueAnalysisChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Transaksi Harian</h3>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total Transaksi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Pendapatan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Rata-rata</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Performa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transactionStats as $index => $stat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($stat->date)->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-semibold text-gray-900">{{ $stat->total_transaksi }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format($stat->total_pendapatan, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm text-gray-900">Rp. {{ number_format($stat->rata_rata_transaksi, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-20 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, ($stat->total_pendapatan / ($transactionStats->max('total_pendapatan') ?: 1)) * 100) }}%"></div>
                                    </div>
                                    <span class="text-xs text-gray-600">{{ round(($stat->total_pendapatan / ($transactionStats->max('total_pendapatan') ?: 1)) * 100, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-chart-line text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Tidak ada data transaksi dalam periode ini</p>
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
    // Daily Transactions Chart
    const dailyCtx = document.getElementById('dailyTransactionsChart');
    if (dailyCtx) {
        const transactionStats = @json($transactionStats);
        const labels = transactionStats.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        });
        const data = transactionStats.map(item => item.total_transaksi);

        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Transaksi',
                    data: data,
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Revenue Analysis Chart
    const revenueCtx = document.getElementById('revenueAnalysisChart');
    if (revenueCtx) {
        const transactionStats = @json($transactionStats);
        const labels = transactionStats.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
        });
        const data = transactionStats.map(item => item.total_pendapatan);

        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: data,
                    backgroundColor: 'rgba(34, 197, 94, 0.8)',
                    borderColor: 'rgb(34, 197, 94)',
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
                        callbacks: {
                            label: function(context) {
                                return 'Rp. ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp. ' + value.toLocaleString('id-ID');
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
    window.open('{{ route('owner.laporan.pelanggan') }}?export=excel&start={{ $start }}&end={{ $end }}', '_blank');
}

function printTable() {
    // Print functionality
    window.print();
}
</script>
@endsection
