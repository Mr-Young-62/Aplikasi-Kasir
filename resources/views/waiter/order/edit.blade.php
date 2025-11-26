@extends('layouts.app')

@section('title', 'Edit Order')
@section('header', 'Edit Order')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('waiter.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="#" class="hover:text-blue-600">Order #{{ $order->id_order }}</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Edit</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Order #{{ $order->id_order }}</h1>
        <p class="text-gray-600">Perbarui informasi pesanan</p>
    </div>

    <!-- Order Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-blue-600">Meja</p>
                <p class="font-medium text-blue-900">Meja {{ $order->meja->nomor_meja }}</p>
            </div>
            <div>
                <p class="text-sm text-blue-600">Tanggal</p>
                <p class="font-medium text-blue-900">{{ $order->tanggal->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-blue-600">Total Item</p>
                <p class="font-medium text-blue-900">{{ $order->detailOrders->count() }} item</p>
            </div>
            <div>
                <p class="text-sm text-blue-600">Total Harga</p>
                <p class="font-medium text-blue-900">Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <form method="POST" action="{{ route('waiter.order.update', $order->id_order) }}">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Status Order -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Order <span class="text-red-500">*</span>
                    </label>
                    <select name="status_order" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="menunggu" {{ $order->status_order === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $order->status_order === 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $order->status_order === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Keterangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan Pesanan
                    </label>
                    <textarea name="keterangan" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Catatan khusus untuk pesanan">{{ old('keterangan', $order->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('waiter.dashboard') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-times mr-2"></i>Kembali
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Update Order
                </button>
            </div>
        </form>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Item Pesanan</h3>
            @if(in_array($order->status_order, ['menunggu', 'diproses']))
                <button type="button" onclick="showAddItemModal()" 
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Tambah Item
                </button>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Masakan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
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
                                        <p class="text-sm text-gray-500">{{ $detail->masakan->kategori }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                Rp. {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $detail->jumlah }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $detail->keterangan ?: '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if(in_array($order->status_order, ['menunggu', 'diproses']))
                                    <form method="POST" action="{{ route('waiter.detail-order.destroy', $detail->id_detail_order) }}" 
                                          onsubmit="return confirm('Hapus item ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t">
                    <tr>
                        <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900">Total</td>
                        <td colspan="3" class="px-4 py-3 text-lg font-bold text-blue-600">
                            Rp. {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Add Item Modal -->
<div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Tambah Item</h3>
            <button onclick="hideAddItemModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form method="POST" action="{{ route('waiter.order.add-detail', $order->id_order) }}">
            @csrf
            
            <div class="space-y-4">
                <!-- Masakan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Masakan</label>
                    <select name="id_masakan" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Masakan</option>
                        @foreach($masakans as $masakan)
                            <option value="{{ $masakan->id_masakan }}">
                                {{ $masakan->nama_masakan }} - Rp. {{ number_format($masakan->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Jumlah -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="jumlah" value="1" min="1" max="99" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Keterangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <input type="text" name="keterangan"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Catatan untuk item ini">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="hideAddItemModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Tambah
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showAddItemModal() {
    document.getElementById('addItemModal').classList.remove('hidden');
}

function hideAddItemModal() {
    document.getElementById('addItemModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('addItemModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideAddItemModal();
    }
});
</script>
@endsection
