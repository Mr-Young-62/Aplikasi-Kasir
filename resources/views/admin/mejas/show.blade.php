@extends('layouts.app')

@section('title', 'Detail Meja')
@section('header', 'Detail Meja')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.mejas.index') }}" class="hover:text-blue-600">Meja</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Detail</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Meja {{ $meja->nomor_meja }}</h1>
        <p class="text-gray-600">Informasi lengkap mengenai meja</p>
    </div>

    <!-- Meja Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Table Info -->
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Meja</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nomor Meja:</span>
                                    <span class="font-medium text-gray-900">{{ $meja->nomor_meja }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kapasitas:</span>
                                    <span class="font-medium text-gray-900">{{ $meja->kapasitas }} orang</span>
                                </div>
                                @if($meja->lokasi)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Lokasi:</span>
                                        <span class="font-medium text-gray-900">{{ $meja->lokasi }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                        {{ $meja->status_meja === 'tersedia' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $meja->status_meja === 'terisi' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $meja->status_meja === 'dipesan' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $meja->status_meja === 'maintenance' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($meja->status_meja) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @if($meja->deskripsi)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h4>
                                <p class="text-gray-600 text-sm">{{ $meja->deskripsi }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- QR Code -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code</h3>
                        <div class="text-center">
                            @if($meja->qr_code && !str_contains($meja->qr_code, 'generated'))
                                <img src="{{ asset('storage/' . $meja->qr_code) }}" 
                                     alt="QR Code" 
                                     class="w-32 h-32 mx-auto rounded-lg mb-4">
                                <a href="{{ route('admin.mejas.download-qr', $meja) }}" 
                                   class="inline-flex items-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    <i class="fas fa-download"></i>
                                    <span>Download QR</span>
                                </a>
                            @else
                                <div class="w-32 h-32 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-qrcode text-gray-400 text-4xl"></i>
                                </div>
                                <p class="text-sm text-gray-500">QR Code belum tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Order -->
            @if($currentOrder)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pesanan Saat Ini</h3>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm font-medium text-yellow-800">Order #{{ $currentOrder->id_order }}</p>
                                <p class="text-sm text-yellow-700">
                                    Pelanggan: {{ $currentOrder->user->name }}
                                </p>
                                <p class="text-sm text-yellow-700">
                                    Waktu: {{ $currentOrder->tanggal->format('H:i') }}
                                </p>
                            </div>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                {{ $currentOrder->status_order }}
                            </span>
                        </div>
                        
                        <div class="border-t border-yellow-200 pt-3">
                            <p class="text-sm font-medium text-yellow-800 mb-2">Detail Pesanan:</p>
                            @foreach($currentOrder->detailOrders as $detail)
                                <div class="flex justify-between text-sm text-yellow-700">
                                    <span>{{ $detail->masakan->nama_masakan }} x{{ $detail->jumlah }}</span>
                                    <span>Rp. {{ number_format($detail->jumlah * $detail->masakan->harga, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <div class="flex justify-between text-sm font-medium text-yellow-800 mt-2 pt-2 border-t border-yellow-200">
                                <span>Total:</span>
                                <span>Rp. {{ number_format($currentOrder->detailOrders->sum(function($detail) { 
                                    return $detail->jumlah * $detail->masakan->harga; 
                                }), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">
                                            #{{ $order->id_order }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600">
                                        {{ $order->tanggal->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $order->user->name }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                            {{ $order->status_order === 'selesai' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $order->status_order === 'diproses' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $order->status_order === 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                            {{ $order->status_order }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-900">
                                        Rp. {{ number_format($order->detailOrders->sum(function($detail) { 
                                            return $detail->jumlah * $detail->masakan->harga; 
                                        }), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                        Belum ada riwayat pesanan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.mejas.edit', $meja) }}" 
                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        <i class="fas fa-edit"></i>
                        <span>Edit Meja</span>
                    </a>
                    
                    <form method="POST" action="{{ route('admin.mejas.toggle-status', $meja) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            <i class="fas fa-sync-alt"></i>
                            <span>Ubah Status</span>
                        </button>
                    </form>
                    
                    @if($meja->qr_code && !str_contains($meja->qr_code, 'generated'))
                        <a href="{{ route('admin.mejas.download-qr', $meja) }}" 
                           class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-download"></i>
                            <span>Download QR</span>
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.mejas.destroy', $meja) }}" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-trash"></i>
                            <span>Hapus Meja</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Orders:</span>
                        <span class="text-gray-900 font-medium">{{ $meja->orders->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Revenue:</span>
                        <span class="text-gray-900 font-medium">
                            Rp. {{ number_format($meja->orders->sum(function($order) { 
                                return $order->detailOrders->sum(function($detail) { 
                                    return $detail->jumlah * $detail->masakan->harga; 
                                }); 
                            }), 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Avg Order Value:</span>
                        <span class="text-gray-900 font-medium">
                            Rp. {{ number_format($meja->orders->count() > 0 ? 
                                $meja->orders->sum(function($order) { 
                                    return $order->detailOrders->sum(function($detail) { 
                                        return $detail->jumlah * $detail->masakan->harga; 
                                    }); 
                                }) / $meja->orders->count() : 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat pada:</span>
                        <span class="text-gray-900">{{ $meja->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diperbarui:</span>
                        <span class="text-gray-900">{{ $meja->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Meja:</span>
                        <span class="text-gray-900">#{{ $meja->id_meja }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
