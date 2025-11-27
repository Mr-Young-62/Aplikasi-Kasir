@extends('layouts.app')

@section('title', 'Riwayat Transaksi')
@section('header', 'Riwayat Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Transaksi</h1>
            <p class="text-gray-600">Daftar semua transaksi yang telah diproses</p>
        </div>
        <a href="{{ route('kasir.dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('kasir.transaksi.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="md:w-48">
                <select name="metode_pembayaran" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Metode</option>
                    <option value="cash" {{ request('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ request('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="kartu" {{ request('metode_pembayaran') == 'kartu' ? 'selected' : '' }}>Kartu</option>
                    <option value="ewallet" {{ request('metode_pembayaran') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
            </div>
            <div class="md:w-48">
                <select name="status_transaksi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="berhasil" {{ request('status_transaksi') == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                    <option value="batal" {{ request('status_transaksi') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="md:w-48">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            <a href="{{ route('kasir.transaksi.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $transaksis->total() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-receipt text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Berhasil</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $transaksis->where('status_transaksi', 'berhasil')->count() }}
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
                    <p class="text-sm text-gray-600 mb-1">Dibatalkan</p>
                    <p class="text-2xl font-bold text-red-600">
                        {{ $transaksis->where('status_transaksi', 'batal')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                    <p class="text-2xl font-bold text-blue-600">
                        Rp. {{ number_format($transaksis->where('status_transaksi', 'berhasil')->sum('total_bayar'), 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Metode</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($transaksis as $transaksi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">#{{ $transaksi->id_transaksi }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm text-gray-900">{{ $transaksi->tanggal->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $transaksi->tanggal->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="#" class="text-sm text-blue-600 hover:text-blue-900">
                                    #{{ $transaksi->order->id_order }}
                                </a>
                                <div class="text-sm text-gray-500">{{ $transaksi->order->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Meja {{ $transaksi->order->meja->nomor_meja }}
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    {{ $transaksi->status_transaksi === 'berhasil' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($transaksi->status_transaksi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('kasir.transaksi.show', $transaksi) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kasir.transaksi.print', $transaksi) }}" 
                                       target="_blank"
                                       class="text-green-600 hover:text-green-900" title="Cetak">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if($transaksi->status_transaksi === 'berhasil')
                                        <form method="POST" action="{{ route('kasir.transaksi.cancel', $transaksi) }}" class="inline" 
                                              onsubmit="return confirm('Batalkan transaksi ini?')" title="Batalkan">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-receipt text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Belum ada data transaksi</p>
                                <p class="text-gray-400 text-sm mt-2">Transaksi akan muncul setelah order selesai</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transaksis->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $transaksis->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
