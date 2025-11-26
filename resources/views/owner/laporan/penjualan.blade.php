@extends('layouts.app')

@section('title', 'Laporan Penjualan')
@section('header', 'Laporan Penjualan')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Penjualan</h1>
        <p class="text-gray-600">Analisis penjualan dan revenue restoran</p>
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>Semua Kategori</option>
                    <option>Makanan</option>
                    <option>Minuman</option>
                    <option>Dessert</option>
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
                    <i class="fas fa-dollar-sign text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format(25000000, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Total Revenue</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>15% dari bulan lalu</span>
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
            <h3 class="text-2xl font-bold text-gray-900 mb-1">156</h3>
            <p class="text-sm text-gray-500">Total Orders</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>8% dari minggu lalu</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-warning-500 to-warning-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-warning-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-warning-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Rp. {{ number_format(160000, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-500">Rata-rata Order</p>
            <div class="mt-4 flex items-center text-xs text-warning-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>5% increase</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-danger-500 to-danger-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">89</h3>
            <p class="text-sm text-gray-500">Pelanggan</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>12% baru</span>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Trend Revenue</h3>
                <select class="text-sm border border-gray-200 rounded-lg px-3 py-1 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>3 Bulan Terakhir</option>
                </select>
            </div>
        </div>
        <div class="p-6">
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Detail Penjualan</h3>
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
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <th class="pb-3">Tanggal</th>
                            <th class="pb-3">Order ID</th>
                            <th class="pb-3">Pelanggan</th>
                            <th class="pb-3">Waiter</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <span class="text-sm text-gray-600">26 Nov 2025</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-medium text-gray-900">#ORD-001</span>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium">JD</span>
                                    </div>
                                    <span class="text-sm text-gray-600">John Doe</span>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">Waiter 1</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. 150.000</span>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Selesai
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-700 text-sm">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <span class="text-sm text-gray-600">26 Nov 2025</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-medium text-gray-900">#ORD-002</span>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium">AS</span>
                                    </div>
                                    <span class="text-sm text-gray-600">Alice Smith</span>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">Waiter 2</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. 200.000</span>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-warning-100 text-warning-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Diproses
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-700 text-sm">
                                        <i class="fas fa-receipt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        const labels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        const data = [2500000, 3200000, 2800000, 3500000, 4000000, 5200000, 4800000];

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
