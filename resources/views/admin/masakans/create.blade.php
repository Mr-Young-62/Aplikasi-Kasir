@extends('layouts.app')

@section('title', 'Tambah Masakan')
@section('header', 'Tambah Masakan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.masakans.index') }}" class="hover:text-blue-600">Masakan</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Tambah</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Tambah Masakan Baru</h1>
        <p class="text-gray-600">Masukkan informasi masakan yang akan ditambahkan</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('admin.masakans.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Nama Masakan -->
                    <div>
                        <label for="nama_masakan" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Masakan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_masakan" id="nama_masakan" required
                            value="{{ old('nama_masakan') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan nama masakan">
                        @error('nama_masakan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="kategori" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2 text-gray-500">Rp.</span>
                            <input type="number" name="harga" id="harga" required min="0" step="100"
                                value="{{ old('harga') }}"
                                class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0">
                        </div>
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Masakan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status Masakan <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="status_masakan" value="tersedia" 
                                    {{ old('status_masakan', 'tersedia') == 'tersedia' ? 'checked' : '' }}
                                    class="mr-2 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Tersedia</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status_masakan" value="habis"
                                    {{ old('status_masakan') == 'habis' ? 'checked' : '' }}
                                    class="mr-2 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm">Habis</span>
                            </label>
                        </div>
                        @error('status_masakan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Gambar -->
                    <div>
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Masakan
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                            <input type="file" name="gambar" id="gambar" accept="image/*"
                                class="hidden" onchange="previewImage(this)">
                            <label for="gambar" class="cursor-pointer">
                                <div id="image-preview" class="mb-4">
                                    <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center mx-auto">
                                        <i class="fas fa-camera text-gray-400 text-2xl"></i>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">Klik untuk upload gambar</p>
                                <p class="text-xs text-gray-400 mt-1">Format: JPEG, PNG, JPG, GIF (Max: 2MB)</p>
                            </label>
                        </div>
                        @error('gambar')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Masukkan deskripsi masakan (opsional)">{{ old('deskripsi') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Maksimal 500 karakter</p>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.masakans.index') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="w-24 h-24 rounded-lg object-cover mx-auto">
            `;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
