@extends('layouts.app')

@section('title', 'Manajemen Meja')
@section('header', 'Manajemen Meja')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Manajemen Meja</h1>
            <p class="text-gray-600">Kelola meja dan status ketersediaan restoran</p>
        </div>
        <a href="{{ route('admin.mejas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Meja</span>
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Meja</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $mejas->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chair text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Tersedia</p>
                    <p class="text-2xl font-bold text-green-600">
                        {{ $mejas->where('status_meja', 'tersedia')->count() }}
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
                    <p class="text-sm text-gray-600 mb-1">Terisi</p>
                    <p class="text-2xl font-bold text-yellow-600">
                        {{ $mejas->where('status_meja', 'terisi')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-yellow-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Maintenance</p>
                    <p class="text-2xl font-bold text-red-600">
                        {{ $mejas->where('status_meja', 'maintenance')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tools text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('admin.mejas.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor meja..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="md:w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            <a href="{{ route('admin.mejas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
        </form>
    </div>

    <!-- Meja Grid -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($mejas as $meja)
                <div class="border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-shadow">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Meja {{ $meja->nomor_meja }}</h3>
                            @if($meja->lokasi)
                                <p class="text-sm text-gray-500">{{ $meja->lokasi }}</p>
                            @endif
                        </div>
                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                            {{ $meja->status_meja === 'tersedia' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $meja->status_meja === 'terisi' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $meja->status_meja === 'dipesan' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $meja->status_meja === 'maintenance' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($meja->status_meja) }}
                        </span>
                    </div>

                    <!-- Capacity -->
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-users mr-2"></i>
                        <span>Kapasitas: {{ $meja->kapasitas }} orang</span>
                    </div>

                    <!-- QR Code -->
                    <div class="mb-4">
                        @if($meja->qr_code && !str_contains($meja->qr_code, 'generated'))
                            <img src="{{ asset('storage/' . $meja->qr_code) }}" 
                                 alt="QR Code" 
                                 class="w-20 h-20 mx-auto rounded-lg">
                        @else
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center mx-auto">
                                <i class="fas fa-qrcode text-gray-400 text-2xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.mejas.show', $meja) }}" 
                               class="text-blue-600 hover:text-blue-900" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.mejas.edit', $meja) }}" 
                               class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.mejas.toggle-status', $meja) }}" class="inline" title="Toggle Status">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-purple-600 hover:text-purple-900">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </form>
                            @if($meja->qr_code && !str_contains($meja->qr_code, 'generated'))
                                <a href="{{ route('admin.mejas.download-qr', $meja) }}" 
                                   class="text-green-600 hover:text-green-900" title="Download QR">
                                    <i class="fas fa-download"></i>
                                </a>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('admin.mejas.destroy', $meja) }}" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus meja ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chair text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500">Belum ada data meja</p>
                    <p class="text-gray-400 text-sm mt-2">Mulai dengan menambahkan meja baru</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($mejas->hasPages())
            <div class="mt-6 pt-6 border-t border-gray-200">
                {{ $mejas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
