@extends('layouts.app')

@section('title', 'Detail Masakan')
@section('header', 'Detail Masakan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.masakans.index') }}" class="hover:text-blue-600">Masakan</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Detail</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $masakan->nama_masakan }}</h1>
        <p class="text-gray-600">Informasi lengkap mengenai masakan</p>
    </div>

    <!-- Masakan Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Image & Basic Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image -->
                    <div class="md:w-1/3">
                        @if($masakan->gambar)
                            <img src="{{ asset('storage/' . $masakan->gambar) }}" 
                                 alt="{{ $masakan->nama_masakan }}" 
                                 class="w-full h-64 object-cover rounded-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Basic Info -->
                    <div class="md:w-2/3 space-y-4">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">{{ $masakan->nama_masakan }}</h2>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                                    {{ $masakan->status_masakan === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $masakan->status_masakan === 'tersedia' ? 'Tersedia' : 'Habis' }}
                                </span>
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ $masakan->kategori }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                            <p class="text-gray-600">
                                {{ $masakan->deskripsi ?: 'Tidak ada deskripsi tersedia' }}
                            </p>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <div class="text-3xl font-bold text-blue-600">
                                Rp. {{ number_format($masakan->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Masakan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-blue-600 font-medium">Total Terjual</p>
                                <p class="text-2xl font-bold text-blue-900">
                                    {{ $masakan->detailOrders->sum('jumlah') }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-green-600 font-medium">Total Revenue</p>
                                <p class="text-2xl font-bold text-green-900">
                                    Rp. {{ number_format($masakan->detailOrders->sum(function($detail) { 
                                        return $detail->jumlah * $detail->masakan->harga; 
                                    }), 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-dollar-sign text-green-600"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-purple-600 font-medium">Order Count</p>
                                <p class="text-2xl font-bold text-purple-900">
                                    {{ $masakan->detailOrders->count() }}
                                </p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-receipt text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pesanan Terkini</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($masakan->detailOrders()->with('order')->latest()->take(5)->get() as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">
                                            #{{ $detail->order->id_order }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-600">
                                        {{ $detail->order->tanggal->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $detail->jumlah }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">
                                        Rp. {{ number_format($detail->jumlah * $masakan->harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                        Belum ada pesanan
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
                    <a href="{{ route('admin.masakans.edit', $masakan) }}" 
                        class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                        <i class="fas fa-edit"></i>
                        <span>Edit Masakan</span>
                    </a>
                    
                    <form method="POST" action="{{ route('admin.masakans.toggle-status', $masakan) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            <i class="fas fa-toggle-on"></i>
                            <span>Ubah Status</span>
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('admin.masakans.destroy', $masakan) }}" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus masakan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class="fas fa-trash"></i>
                            <span>Hapus Masakan</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat pada:</span>
                        <span class="text-gray-900">{{ $masakan->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diperbarui:</span>
                        <span class="text-gray-900">{{ $masakan->updated_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Masakan:</span>
                        <span class="text-gray-900">#{{ $masakan->id_masakan }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
