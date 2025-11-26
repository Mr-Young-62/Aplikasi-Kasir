@extends('layouts.app')

@section('title', 'Kasir Dashboard')
@section('header', 'Kasir Dashboard')

@section('content')
<div class="fade-in">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="card-hover bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Ready Orders</p>
                    <p class="text-2xl font-bold text-green-600">{{ $readyOrders->count() }}</p>
                    <p class="text-xs text-gray-600 mt-1">Waiting for payment</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Today's Revenue</p>
                    <p class="text-2xl font-bold text-blue-600">Rp. {{ number_format($todayTransaksi, 0, ',', '.') }}</p>
                    <p class="text-xs text-green-600 mt-1">+12% from yesterday</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Transactions Today</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $todayCount }}</p>
                    <p class="text-xs text-gray-600 mt-1">Completed payments</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card-hover bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Avg Transaction</p>
                    <p class="text-2xl font-bold text-orange-600">Rp. {{ number_format($todayCount > 0 ? $todayTransaksi / $todayCount : 0, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-600 mt-1">Per transaction</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Ready Orders and Recent Transactions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Ready Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Ready for Payment</h3>
                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ $readyOrders->count() }} orders
                </span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($readyOrders as $order)
                        <div class="card-hover border border-green-200 bg-green-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-green-200 rounded-lg flex items-center justify-center">
                                        <span class="text-lg font-bold text-green-700">#{{ $order->id_order }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Table {{ $order->no_meja }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->user?->name ?? 'N/A' }} • {{ $order->tanggal?->format('H:i') ?? '-' }}</p>
                                        <p class="text-sm font-medium text-green-700 mt-1">Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('kasir.transaksi.create', $order->id_order) }}" class="btn-hover bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Process
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Order Items Preview -->
                            <div class="mt-3 pt-3 border-t border-green-200">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($order->detailOrders->take(3) as $detail)
                                        <span class="inline-flex px-2 py-1 text-xs bg-white text-green-700 rounded-full border border-green-300">
                                            {{ $detail->masakan->nama_masakan }} ({{ $detail->jumlah }})
                                        </span>
                                    @endforeach
                                    @if($order->detailOrders->count() > 3)
                                        <span class="inline-flex px-2 py-1 text-xs bg-white text-green-700 rounded-full border border-green-300">
                                            +{{ $order->detailOrders->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium mb-2">No orders ready for payment</p>
                            <p class="text-gray-400 text-sm">Orders will appear here when marked as completed by waiters</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Recent Transactions</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($myTransaksi as $transaksi)
                        <div class="card-hover border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <span class="text-lg font-bold text-blue-600">#{{ $transaksi->id_transaksi }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Order #{{ $transaksi->order?->id_order ?? '-' }}</p>
                                        <p class="text-sm text-gray-600">Table {{ $transaksi->order?->no_meja ?? '-' }} • {{ $transaksi->tanggal?->format('H:i') ?? '-' }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                                {{ $transaksi->metode_pembayaran === 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst($transaksi->metode_pembayaran) }}
                                            </span>
                                            <span class="text-sm font-medium text-gray-900">Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('kasir.transaksi.show', $transaksi->id_transaksi) }}" class="btn-hover text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('kasir.transaksi.print', $transaksi->id_transaksi) }}" class="btn-hover text-gray-600 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium mb-2">No transactions yet</p>
                            <p class="text-gray-400 text-sm">Process orders to create transactions</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Today's Payment Methods</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                    <div class="w-12 h-12 bg-green-200 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-green-900">{{ $myTransaksi->where('metode_pembayaran', 'cash')->count() }}</p>
                    <p class="text-sm text-green-700">Cash Payments</p>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                    <div class="w-12 h-12 bg-blue-200 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-blue-900">{{ $myTransaksi->where('metode_pembayaran', 'transfer')->count() }}</p>
                    <p class="text-sm text-blue-700">Transfers</p>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 text-center">
                    <div class="w-12 h-12 bg-purple-200 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-purple-900">{{ $myTransaksi->where('metode_pembayaran', 'kartu')->count() }}</p>
                    <p class="text-sm text-purple-700">Card Payments</p>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-center">
                    <div class="w-12 h-12 bg-orange-200 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="text-2xl font-bold text-orange-900">{{ $myTransaksi->where('metode_pembayaran', 'ewallet')->count() }}</p>
                    <p class="text-sm text-orange-700">E-Wallets</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
