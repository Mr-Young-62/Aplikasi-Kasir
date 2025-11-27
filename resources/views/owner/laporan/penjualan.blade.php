@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('header', 'Laporan Penjualan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Penjualan</h1>
        <p class="text-gray-600">Analisis penjualan dan revenue restoran</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <form method="GET" action="{{ route('owner.laporan.penjualan') }}" class="flex flex-col lg:flex-row gap-4">
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
                <a href="{{ route('owner.laporan.penjualan') }}" 
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
                    <i class="fas fa-dollar-sign text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Total Revenue</p>
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
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalTransactions }}</h3>
            <p class="text-sm text-gray-500">Total Transaksi</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Rata-rata: Rp. {{ number_format($totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $dailyRevenue->count() }}</h3>
            <p class="text-sm text-gray-500">Hari Aktif</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Rata-rata/hari: Rp. {{ number_format($dailyRevenue->count() > 0 ? $totalRevenue / $dailyRevenue->count() : 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-receipt text-purple-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $transaksis->count() }}</h3>
            <p class="text-sm text-gray-500">Detail Transaksi</p>
            <div class="mt-4">
                <span class="text-xs text-gray-600">Dalam periode ini</span>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Trend Revenue Harian</h3>
            <button onclick="exportChart()" class="text-sm text-blue-600 hover:text-blue-700">
                <i class="fas fa-download mr-1"></i>Export
            </button>
        </div>
        <div class="h-80">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Detail Transaksi</h3>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kasir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meja</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transaksis as $transaksi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm text-gray-900">{{ $transaksi->tanggal->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaksi->tanggal->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">#{{ $transaksi->id_transaksi }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">#{{ $transaksi->order->id_order }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $transaksi->user->name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $transaksi->order->meja ? 'Meja ' . $transaksi->order->meja->nomor_meja : 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    @switch($transaksi->metode_pembayaran)
                                        @case('cash')
                                            <i class="fas fa-money-bill-wave text-green-600"></i>
                                            <span class="text-sm text-gray-900">Cash</span>
                                            @break
                                        @case('transfer')
                                            <i class="fas fa-exchange-alt text-blue-600"></i>
                                            <span class="text-sm text-gray-900">Transfer</span>
                                            @break
                                        @case('kartu')
                                            <i class="fas fa-credit-card text-purple-600"></i>
                                            <span class="text-sm text-gray-900">Kartu</span>
                                            @break
                                        @case('ewallet')
                                            <i class="fas fa-wallet text-orange-600"></i>
                                            <span class="text-sm text-gray-900">E-Wallet</span>
                                            @break
                                    @endswitch
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    {{ $transaksi->status_transaksi === 'berhasil' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($transaksi->status_transaksi) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-receipt text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Tidak ada transaksi dalam periode ini</p>
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
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        const dailyRevenue = @json($dailyRevenue);
        const labels = Object.keys(dailyRevenue).sort();
        const data = labels.map(date => dailyRevenue[date]);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels.map(date => {
                    const d = new Date(date);
                    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
                }),
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

function exportChart() {
    // Export chart functionality
    alert('Export chart functionality would be implemented here');
}

function exportTable() {
    // Export table functionality
    window.open('{{ route('owner.laporan.penjualan') }}?export=excel&start={{ $start }}&end={{ $end }}', '_blank');
}

function printTable() {
    // Print functionality
    window.print();
}
</script>
@endsection
