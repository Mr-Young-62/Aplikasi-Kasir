@extends('layouts.app')

@section('title', 'Laporan Masakan')
@section('header', 'Laporan Masakan')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Masakan</h1>
        <p class="text-gray-600">Analisis penjualan menu dan performa masakan</p>
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
                    <i class="fas fa-utensils text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">8</h3>
            <p class="text-sm text-gray-500">Total Menu</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>2 menu baru</span>
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
            <h3 class="text-2xl font-bold text-gray-900 mb-1">245</h3>
            <p class="text-sm text-gray-500">Total Terjual</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>12% kemarin</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-warning-500 to-warning-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-warning-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-warning-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">4.8</h3>
            <p class="text-sm text-gray-500">Rating Rata-rata</p>
            <div class="mt-4 flex items-center text-xs text-warning-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>Excellent</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-danger-500 to-danger-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-fire text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Nasi Goreng</h3>
            <p class="text-sm text-gray-500">Menu Terlaris</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>45 terjual</span>
            </div>
        </div>
    </div>

    <!-- Top Selling Items -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Items Chart -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Top 5 Menu Terlaris</h3>
            </div>
            <div class="p-6">
                <canvas id="topItemsChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Distribusi Kategori</h3>
            </div>
            <div class="p-6">
                <canvas id="categoryChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Menu Performance Table -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Performa Menu</h3>
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
                            <th class="pb-3">Nama Masakan</th>
                            <th class="pb-3">Kategori</th>
                            <th class="pb-3">Harga</th>
                            <th class="pb-3">Terjual</th>
                            <th class="pb-3">Total Revenue</th>
                            <th class="pb-3">Rating</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-drumstick-bite text-orange-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Nasi Goreng</p>
                                        <p class="text-xs text-gray-500">Favorit</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    Makanan
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. 25.000</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">45</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format(1125000, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center space-x-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star-half-alt text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">4.5</span>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Tersedia
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700 text-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-700 text-sm">
                                        <i class="fas fa-chart-bar"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-coffee text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Es Teh Manis</p>
                                        <p class="text-xs text-gray-500">Best Seller</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Minuman
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. 8.000</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">38</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format(304000, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center space-x-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">5.0</span>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Tersedia
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700 text-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-700 text-sm">
                                        <i class="fas fa-chart-bar"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-ice-cream text-pink-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Es Krim Vanilla</p>
                                        <p class="text-xs text-gray-500">Dessert</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                    Dessert
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. 15.000</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">22</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format(330000, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center space-x-1">
                                    <div class="flex text-yellow-400">
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="fas fa-star text-xs"></i>
                                        <i class="far fa-star text-xs"></i>
                                    </div>
                                    <span class="text-xs text-gray-500">4.0</span>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-warning-100 text-warning-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Habis
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700 text-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-700 text-sm">
                                        <i class="fas fa-chart-bar"></i>
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
    // Top Items Chart
    const topItemsCtx = document.getElementById('topItemsChart');
    if (topItemsCtx) {
        new Chart(topItemsCtx, {
            type: 'bar',
            data: {
                labels: ['Nasi Goreng', 'Es Teh Manis', 'Mie Ayam', 'Ayam Bakar', 'Es Krim'],
                datasets: [{
                    label: 'Terjual',
                    data: [45, 38, 32, 28, 22],
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
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Makanan', 'Minuman', 'Dessert'],
                datasets: [{
                    data: [65, 25, 10],
                    backgroundColor: [
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
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
                    }
                }
            }
        });
    }
});
</script>
@endsection
