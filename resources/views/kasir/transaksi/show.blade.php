@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('header', 'Detail Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('kasir.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Detail Transaksi</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Transaksi #{{ $transaksi->id_transaksi }}</h1>
        <p class="text-gray-600">Detail pembayaran untuk Order #{{ $transaksi->order->id_order }}</p>
    </div>

    <!-- Transaction Status -->
    <div class="mb-6">
        @if($transaksi->status_transaksi === 'berhasil')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-green-800">Transaksi Berhasil</p>
                        <p class="text-sm text-green-700">Pembayaran telah diproses dengan sukses</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-red-800">Transaksi Dibatalkan</p>
                        <p class="text-sm text-red-700">Transaksi ini telah dibatalkan</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Transaction Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Payment Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h3>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">ID Transaksi</p>
                        <p class="font-medium text-gray-900">#{{ $transaksi->id_transaksi }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal</p>
                        <p class="font-medium text-gray-900">{{ $transaksi->tanggal->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Kasir</p>
                        <p class="font-medium text-gray-900">{{ $transaksi->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Metode Pembayaran</p>
                        <div class="flex items-center space-x-2">
                            @switch($transaksi->metode_pembayaran)
                                @case('cash')
                                    <i class="fas fa-money-bill-wave text-green-600"></i>
                                    <span class="font-medium text-gray-900">Cash</span>
                                    @break
                                @case('transfer')
                                    <i class="fas fa-exchange-alt text-blue-600"></i>
                                    <span class="font-medium text-gray-900">Transfer</span>
                                    @break
                                @case('kartu')
                                    <i class="fas fa-credit-card text-purple-600"></i>
                                    <span class="font-medium text-gray-900">Kartu</span>
                                    @break
                                @case('ewallet')
                                    <i class="fas fa-wallet text-orange-600"></i>
                                    <span class="font-medium text-gray-900">E-Wallet</span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                    @if($transaksi->no_referensi)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">No. Referensi</p>
                            <p class="font-medium text-gray-900">{{ $transaksi->no_referensi }}</p>
                        </div>
                    @endif
                </div>

                <!-- Payment Summary -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Harga</span>
                            <span class="font-medium text-gray-900">Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Uang Bayar</span>
                            <span class="font-medium text-gray-900">Rp. {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
                        </div>
                        @if($transaksi->kembalian > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kembalian</span>
                                <span class="font-medium text-green-600">Rp. {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between pt-3 border-t border-gray-200">
                            <span class="text-lg font-semibold text-gray-900">Status</span>
                            <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                                {{ $transaksi->status_transaksi === 'berhasil' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($transaksi->status_transaksi) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h3>
                
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
                            @foreach($transaksi->order->detailOrders as $detail)
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
                                <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900">Total</td>
                                <td class="px-4 py-3 text-lg font-bold text-blue-600">
                                    Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Order Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Order</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order ID:</span>
                        <span class="text-gray-900">#{{ $transaksi->order->id_order }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Meja:</span>
                        <span class="text-gray-900">Meja {{ $transaksi->order->meja->nomor_meja }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pelayan:</span>
                        <span class="text-gray-900">{{ $transaksi->order->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Order:</span>
                        <span class="text-gray-900">{{ $transaksi->order->tanggal->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status Order:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            Selesai
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('kasir.transaksi.print', $transaksi->id_transaksi) }}" 
                       target="_blank"
                       class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-print"></i>
                        <span>Cetak Struk</span>
                    </a>
                    
                    @if($transaksi->status_transaksi === 'berhasil')
                        <form method="POST" action="{{ route('kasir.transaksi.cancel', $transaksi->id_transaksi) }}" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <i class="fas fa-times"></i>
                                <span>Batalkan Transaksi</span>
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('kasir.dashboard') }}" 
                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
