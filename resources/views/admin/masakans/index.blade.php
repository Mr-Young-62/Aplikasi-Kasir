@extends('layouts.app')

@section('title', 'Manajemen Masakan')
@section('header', 'Manajemen Masakan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Manajemen Masakan</h1>
            <p class="text-gray-600">Kelola menu dan harga masakan restoran</p>
        </div>
        <a href="{{ route('admin.masakans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
            <i class="fas fa-plus"></i>
            <span>Tambah Masakan</span>
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form method="GET" action="{{ route('admin.masakans.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari masakan..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="md:w-48">
                <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:w-48">
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                <i class="fas fa-search mr-2"></i>Cari
            </button>
            <a href="{{ route('admin.masakans.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                <i class="fas fa-times mr-2"></i>Reset
            </a>
        </form>
    </div>

    <!-- Masakan Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Masakan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($masakans as $masakan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($masakan->foto)
                                    <img src="{{ asset('storage/' . $masakan->foto) }}" 
                                         alt="{{ $masakan->nama_masakan }}" 
                                         class="w-16 h-16 rounded-lg object-cover">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-utensils text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $masakan->nama_masakan }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($masakan->deskripsi, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                    {{ $masakan->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp. {{ number_format($masakan->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    {{ $masakan->status_masakan === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $masakan->status_masakan === 'tersedia' ? 'Tersedia' : 'Habis' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.masakans.show', $masakan) }}" class="text-blue-600 hover:text-blue-900" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.masakans.edit', $masakan) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.masakans.toggle-status', $masakan) }}" class="inline" title="Toggle Status">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-toggle-on"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.masakans.destroy', $masakan) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus masakan ini?')" class="inline" title="Hapus">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-utensils text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500">Belum ada data masakan</p>
                                <p class="text-gray-400 text-sm mt-2">Mulai dengan menambahkan masakan baru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($masakans->hasPages())
            <div class="bg-white px-6 py-4 border-t border-gray-200">
                {{ $masakans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
