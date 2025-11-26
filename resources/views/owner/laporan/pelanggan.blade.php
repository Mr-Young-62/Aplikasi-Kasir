@extends('layouts.app')

@section('title', 'Laporan Pelanggan')
@section('header', 'Laporan Pelanggan')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Pelanggan</h1>
        <p class="text-gray-600">Analisis pelanggan dan perilaku pembelian</p>
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Pelanggan</label>
                <select class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    <option>Semua Pelanggan</option>
                    <option>Pelanggan Baru</option>
                    <option>Pelanggan Setia</option>
                    <option>Pelanggan VIP</option>
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
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalCustomers ?? 0 }}</h3>
            <p class="text-sm text-gray-500">Total Pelanggan</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>12% bulan ini</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-success-500 to-success-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-user-plus text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">15</h3>
            <p class="text-sm text-gray-500">Pelanggan Baru</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>8% minggu ini</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-warning-500 to-warning-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-crown text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-warning-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-warning-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">28</h3>
            <p class="text-sm text-gray-500">Pelanggan Setia</p>
            <div class="mt-4 flex items-center text-xs text-warning-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>Repeat >5x</span>
            </div>
        </div>

        <div class="card-hover bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-danger-500 to-danger-600 rounded-xl flex items-center justify-center shadow-medium">
                    <i class="fas fa-star text-white text-xl"></i>
                </div>
                <div class="w-8 h-8 bg-success-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-arrow-up text-success-600 text-xs"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">4.7</h3>
            <p class="text-sm text-gray-500">Rating Rata-rata</p>
            <div class="mt-4 flex items-center text-xs text-success-600">
                <i class="fas fa-arrow-up mr-1"></i>
                <span>Excellent</span>
            </div>
        </div>
    </div>

    <!-- Customer Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Customer Growth -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Pertumbuhan Pelanggan</h3>
            </div>
            <div class="p-6">
                <canvas id="customerGrowthChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Customer Segments -->
        <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Segmentasi Pelanggan</h3>
            </div>
            <div class="p-6">
                <canvas id="customerSegmentsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Customers -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Top Pelanggan</h3>
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Customer Card 1 -->
                <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border border-primary-200">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                            <span class="text-xl font-bold text-white">JD</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">John Doe</h4>
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
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-600 text-white">
                                VIP
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Orders</span>
                            <span class="font-semibold text-gray-900">23</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Spent</span>
                            <span class="font-semibold text-gray-900">Rp. 2.345.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Avg. Order</span>
                            <span class="font-semibold text-gray-900">Rp. 102.000</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Card 2 -->
                <div class="bg-gradient-to-br from-success-50 to-success-100 rounded-xl p-6 border border-success-200">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-success-500 to-success-600 rounded-full flex items-center justify-center">
                            <span class="text-xl font-bold text-white">AS</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">Alice Smith</h4>
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
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-600 text-white">
                                Setia
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Orders</span>
                            <span class="font-semibold text-gray-900">18</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Spent</span>
                            <span class="font-semibold text-gray-900">Rp. 1.680.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Avg. Order</span>
                            <span class="font-semibold text-gray-900">Rp. 93.000</span>
                        </div>
                    </div>
                </div>

                <!-- Customer Card 3 -->
                <div class="bg-gradient-to-br from-warning-50 to-warning-100 rounded-xl p-6 border border-warning-200">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-warning-500 to-warning-600 rounded-full flex items-center justify-center">
                            <span class="text-xl font-bold text-white">BJ</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">Bob Johnson</h4>
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
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-warning-600 text-white">
                                Baru
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Orders</span>
                            <span class="font-semibold text-gray-900">7</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Total Spent</span>
                            <span class="font-semibold text-gray-900">Rp. 455.000</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Avg. Order</span>
                            <span class="font-semibold text-gray-900">Rp. 65.000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Table -->
    <div class="bg-white rounded-2xl shadow-soft border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Semua Pelanggan</h3>
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
                            <th class="pb-3">Pelanggan</th>
                            <th class="pb-3">Email</th>
                            <th class="pb-3">Total Orders</th>
                            <th class="pb-3">Total Spent</th>
                            <th class="pb-3">Avg. Order</th>
                            <th class="pb-3">Rating</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-semibold text-white">JD</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">John Doe</p>
                                        <p class="text-xs text-gray-500">Member sejak Nov 2024</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">john.doe@email.com</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">23</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format(2345000, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">Rp. {{ number_format(102000, 0, ',', '.') }}</span>
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
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    <i class="fas fa-crown mr-1"></i>
                                    VIP
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-700 text-sm">
                                        <i class="fas fa-envelope"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-success-500 to-success-600 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-semibold text-white">AS</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Alice Smith</p>
                                        <p class="text-xs text-gray-500">Member sejak Okt 2024</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">alice.smith@email.com</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">18</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm font-semibold text-gray-900">Rp. {{ number_format(1680000, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4">
                                <span class="text-sm text-gray-600">Rp. {{ number_format(93000, 0, ',', '.') }}</span>
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
                                    <i class="fas fa-heart mr-1"></i>
                                    Setia
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex space-x-2">
                                    <button class="text-primary-600 hover:text-primary-700 text-sm">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-700 text-sm">
                                        <i class="fas fa-envelope"></i>
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
    // Customer Growth Chart
    const growthCtx = document.getElementById('customerGrowthChart');
    if (growthCtx) {
        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov'],
                datasets: [{
                    label: 'Pelanggan Baru',
                    data: [5, 8, 12, 15, 18, 22, 25, 28, 32, 35, 38],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Total Pelanggan',
                    data: [10, 18, 30, 45, 63, 85, 110, 138, 170, 205, 243],
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
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

    // Customer Segments Chart
    const segmentsCtx = document.getElementById('customerSegmentsChart');
    if (segmentsCtx) {
        new Chart(segmentsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pelanggan Baru', 'Pelanggan Setia', 'Pelanggan VIP', 'Pelanggan Pasif'],
                datasets: [{
                    data: [35, 40, 15, 10],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(156, 163, 175, 0.8)'
                    ],
                    borderWidth: 0
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
