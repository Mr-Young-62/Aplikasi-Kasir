@extends('layouts.app')

@section('title', 'Detail Order')
@section('header', 'Detail Order')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('pelanggan.orders') }}" class="hover:text-blue-600">My Orders</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Order #{{ $order->id_order }}</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Order #{{ $order->id_order }}</h1>
        <p class="text-gray-600">Detail pesanan Anda</p>
    </div>

    <!-- Order Status -->
    <div class="mb-6">
        @switch($order->status_order)
            @case('menunggu')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Menunggu Konfirmasi</p>
                            <p class="text-sm text-yellow-700">Pesanan Anda sedang menunggu konfirmasi dari waiter</p>
                        </div>
                    </div>
                </div>
                @break
            @case('diproses')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-fire text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-800">Sedang Diproses</p>
                            <p class="text-sm text-blue-700">Pesanan Anda sedang disiapkan oleh dapur</p>
                        </div>
                    </div>
                </div>
                @break
            @case('selesai')
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-800">Pesanan Selesai</p>
                            <p class="text-sm text-green-700">Pesanan Anda sudah siap, silakan melakukan pembayaran</p>
                        </div>
                    </div>
                </div>
                @break
            @case('dibayar')
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-purple-800">Sudah Dibayar</p>
                            <p class="text-sm text-purple-700">Pembayaran telah dilakukan, terima kasih!</p>
                        </div>
                    </div>
                </div>
                @break
            @case('dibatal')
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-red-800">Dibatalkan</p>
                            <p class="text-sm text-red-700">Pesanan ini telah dibatalkan</p>
                        </div>
                    </div>
                </div>
                @break
        @endswitch
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pesanan</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Order ID</p>
                        <p class="font-medium text-gray-900">#{{ $order->id_order }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-medium text-gray-900">{{ $order->tanggal->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Meja</p>
                        <p class="font-medium text-gray-900">Meja {{ $order->meja->nomor_meja }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Jenis Pesanan</p>
                        <p class="font-medium text-gray-900">Self-Order</p>
                    </div>
                </div>

                @if($order->keterangan)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-1">Catatan Pesanan</p>
                        <p class="text-gray-900">{{ $order->keterangan }}</p>
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->detailOrders as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-3">
                                            @if($detail->masakan->gambar)
                                                <img src="{{ asset('storage/' . $detail->masakan->gambar) }}" 
                                                     alt="{{ $detail->masakan->nama_masakan }}" 
                                                     class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-utensils text-gray-400 text-sm"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $detail->masakan->nama_masakan }}</p>
                                                @if($detail->keterangan)
                                                    <p class="text-sm text-gray-500">{{ $detail->keterangan }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-900">{{ $detail->jumlah }}</td>
                                    <td class="px-4 py-3 text-right text-gray-900">
                                        Rp. {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-medium text-gray-900">
                                        Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900">Subtotal</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    Rp. {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900">Pajak (10%)</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    Rp. {{ number_format($order->total_harga * 0.1, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-lg font-bold text-blue-600">Total</td>
                                <td class="px-4 py-3 text-lg font-bold text-blue-600">
                                    Rp. {{ number_format($order->total_harga * 1.1, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Payment Info (if paid) -->
            @if($order->transaksi)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">ID Transaksi</p>
                            <p class="font-medium text-gray-900">#{{ $order->transaksi->id_transaksi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Bayar</p>
                            <p class="font-medium text-gray-900">{{ $order->transaksi->tanggal->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Metode Pembayaran</p>
                            <p class="font-medium text-gray-900">{{ ucfirst($order->transaksi->metode_pembayaran) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Pembayaran</p>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                {{ ucfirst($order->transaksi->status_transaksi) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Timeline -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Pesanan</h3>
                
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-check text-blue-600 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Order Dibuat</p>
                            <p class="text-xs text-gray-500">{{ $order->tanggal->format('H:i') }}</p>
                        </div>
                    </div>
                    
                    @if(in_array($order->status_order, ['diproses', 'selesai', 'dibayar']))
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dikonfirmasi</p>
                                <p class="text-xs text-gray-500">Waiter telah konfirmasi</p>
                            </div>
                        </div>
                    @endif
                    
                    @if(in_array($order->status_order, ['diproses', 'selesai', 'dibayar']))
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Diproses</p>
                                <p class="text-xs text-gray-500">Dapur sedang menyiapkan</p>
                            </div>
                        </div>
                    @endif
                    
                    @if(in_array($order->status_order, ['selesai', 'dibayar']))
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-blue-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Selesai</p>
                                <p class="text-xs text-gray-500">Pesanan siap disajikan</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($order->status_order === 'dibayar')
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-600 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Dibayar</p>
                                <p class="text-xs text-gray-500">Pembayaran selesai</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('pelanggan.orders') }}" 
                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        <i class="fas fa-list"></i>
                        <span>Lihat Semua Order</span>
                    </a>
                    
                    @if($order->status_order === 'menunggu')
                        <form method="POST" action="{{ route('pelanggan.order.cancel', $order->id_order) }}" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class="fas fa-times"></i>
                                <span>Batalkan Pesanan</span>
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('pelanggan.menu') }}" 
                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-plus"></i>
                        <span>Pesan Lagi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
