@extends('layouts.app')

@section('title', 'Edit Meja')
@section('header', 'Edit Meja')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('admin.mejas.index') }}" class="hover:text-blue-600">Meja</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Meja</h1>
        <p class="text-gray-600">Perbarui informasi meja: <strong>Meja {{ $meja->nomor_meja }}</strong></p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('admin.mejas.update', $meja) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Nomor Meja -->
                    <div>
                        <label for="nomor_meja" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Meja <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_meja" id="nomor_meja" required
                            value="{{ old('nomor_meja', $meja->nomor_meja) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Contoh: M1, T1, VIP1">
                        @error('nomor_meja')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kapasitas -->
                    <div>
                        <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-2">
                            Kapasitas <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" name="kapasitas" id="kapasitas" required min="1" max="20"
                                value="{{ old('kapasitas', $meja->kapasitas) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Jumlah kursi">
                            <span class="absolute right-3 top-2 text-gray-500">orang</span>
                        </div>
                        @error('kapasitas')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi
                        </label>
                        <input type="text" name="lokasi" id="lokasi"
                            value="{{ old('lokasi', $meja->lokasi) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Contoh: Lantai 1, Outdoor, VIP Room">
                        @error('lokasi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Meja -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status Meja <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50
                                {{ old('status_meja', $meja->status_meja) == 'tersedia' ? 'bg-blue-50 border-blue-500' : '' }}">
                                <input type="radio" name="status_meja" value="tersedia" 
                                    {{ old('status_meja', $meja->status_meja) == 'tersedia' ? 'checked' : '' }}
                                    class="mr-2 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <span class="text-sm font-medium">Tersedia</span>
                                    <p class="text-xs text-gray-500">Meja bisa digunakan</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50
                                {{ old('status_meja') == 'terisi' ? 'bg-blue-50 border-blue-500' : '' }}">
                                <input type="radio" name="status_meja" value="terisi"
                                    {{ old('status_meja') == 'terisi' ? 'checked' : '' }}
                                    class="mr-2 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <span class="text-sm font-medium">Terisi</span>
                                    <p class="text-xs text-gray-500">Sedang digunakan</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50
                                {{ old('status_meja') == 'dipesan' ? 'bg-blue-50 border-blue-500' : '' }}">
                                <input type="radio" name="status_meja" value="dipesan"
                                    {{ old('status_meja') == 'dipesan' ? 'checked' : '' }}
                                    class="mr-2 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <span class="text-sm font-medium">Dipesan</span>
                                    <p class="text-xs text-gray-500">Ada reservasi</p>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50
                                {{ old('status_meja') == 'maintenance' ? 'bg-blue-50 border-blue-500' : '' }}">
                                <input type="radio" name="status_meja" value="maintenance"
                                    {{ old('status_meja') == 'maintenance' ? 'checked' : '' }}
                                    class="mr-2 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <span class="text-sm font-medium">Maintenance</span>
                                    <p class="text-xs text-gray-500">Dalam perbaikan</p>
                                </div>
                            </label>
                        </div>
                        @error('status_meja')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- QR Code -->
                    <div>
                        <label for="qr_code" class="block text-sm font-medium text-gray-700 mb-2">
                            QR Code Meja
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gray-400 transition-colors">
                            <input type="file" name="qr_code" id="qr_code" accept="image/*"
                                class="hidden" onchange="previewImage(this)">
                            <label for="qr_code" class="cursor-pointer">
                                <div id="image-preview" class="mb-4">
                                    @if($meja->qr_code && !str_contains($meja->qr_code, 'generated'))
                                        <img src="{{ asset('storage/' . $meja->qr_code) }}" 
                                             alt="Current QR Code" 
                                             class="w-24 h-24 rounded-lg object-cover mx-auto">
                                    @else
                                        <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center mx-auto">
                                            <i class="fas fa-qrcode text-gray-400 text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">Klik untuk ganti QR Code</p>
                                <p class="text-xs text-gray-400 mt-1">Format: JPEG, PNG, JPG (Max: 1MB)</p>
                                @if($meja->qr_code && !str_contains($meja->qr_code, 'generated'))
                                    <p class="text-xs text-gray-500 mt-2">QR Code saat ini: {{ basename($meja->qr_code) }}</p>
                                @endif
                            </label>
                        </div>
                        @error('qr_code')
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
                            placeholder="Masukkan deskripsi meja (opsional)">{{ old('deskripsi', $meja->deskripsi) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Maksimal 200 karakter</p>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Status Warning -->
                    @if($meja->orders()->whereIn('status_order', ['menunggu', 'diproses'])->count() > 0)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-yellow-800">Perhatian</p>
                                    <p class="text-sm text-yellow-700">
                                        Meja ini memiliki {{ $meja->orders()->whereIn('status_order', ['menunggu', 'diproses'])->count() }} pesanan aktif. 
                                        Mengubah status mungkin memengaruhi operasional.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.mejas.show', $meja) }}" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update
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
