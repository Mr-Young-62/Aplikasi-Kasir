@extends('layouts.app')

@section('title', 'My Orders')
@section('header', 'My Orders')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Orders</h1>
            <p class="text-gray-600">Riwayat pesanan Anda</p>
        </div>
        <a href="{{ route('pelanggan.menu') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Pesan Lagi</span>
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-lg p-2 mb-6">
        <div class="flex space-x-2">
            <a href="{{ route('pelanggan.orders') }}" 
               class="flex-1 px-4 py-2 rounded-lg text-center transition-colors
                   {{ !request('status') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Semua
            </a>
            <a href="{{ route('pelanggan.orders', ['status' => 'menunggu']) }}" 
               class="flex-1 px-4 py-2 rounded-lg text-center transition-colors
                   {{ request('status') === 'menunggu' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Menunggu
            </a>
            <a href="{{ route('pelanggan.orders', ['status' => 'diproses']) }}" 
               class="flex-1 px-4 py-2 rounded-lg text-center transition-colors
                   {{ request('status') === 'diproses' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Diproses
            </a>
            <a href="{{ route('pelanggan.orders', ['status' => 'selesai']) }}" 
               class="flex-1 px-4 py-2 rounded-lg text-center transition-colors
                   {{ request('status') === 'selesai' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Selesai
            </a>
            <a href="{{ route('pelanggan.orders', ['status' => 'dibayar']) }}" 
               class="flex-1 px-4 py-2 rounded-lg text-center transition-colors
                   {{ request('status') === 'dibayar' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                Dibayar
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Order</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $orders->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-receipt text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Menunggu</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $orders->where('status_order', 'menunggu')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Selesai</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $orders->whereIn('status_order', ['selesai', 'dibayar'])->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Spending</p>
                    <p class="text-2xl font-bold text-purple-600">
                        Rp. {{ number_format($orders->where('status_order', 'dibayar')->sum('total_harga'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">#{{ $order->id_order }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm text-gray-900">{{ $order->tanggal->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->tanggal->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Meja {{ $order->meja->nomor_meja }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->detailOrders->count() }} item
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                Rp. {{ number_format($order->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    @switch($order->status_order)
                                        @case('menunggu')
                                            bg-yellow-100 text-yellow-800
                                            @break
                                        @case('diproses')
                                            bg-blue-100 text-blue-800
                                            @break
                                        @case('selesai')
                                            bg-green-100 text-green-800
                                            @break
                                        @case('dibayar')
                                            bg-purple-100 text-purple-800
                                            @break
                                        @case('dibatal')
                                            bg-red-100 text-red-800
                                            @break
                                    @endswitch">
                                    {{ ucfirst($order->status_order) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('pelanggan.order.show', $order) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($order->status_order === 'menunggu')
                                        <form method="POST" action="{{ route('pelanggan.order.cancel', $order) }}" class="inline" 
                                              onsubmit="return confirm('Batalkan pesanan ini?')" title="Batalkan">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if($order->status_order === 'selesai' && !$order->transaksi)
                                        <a href="#" class="text-green-600 hover:text-green-900" title="Bayar">
                                            <i class="fas fa-dollar-sign"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-receipt text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Belum ada pesanan</p>
                                <p class="text-gray-400 text-sm mt-2">Mulai pesan menu favorit Anda</p>
                                <div class="mt-4">
                                    <a href="{{ route('pelanggan.menu') }}" 
                                       class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-utensils"></i>
                                        <span>Lihat Menu</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
