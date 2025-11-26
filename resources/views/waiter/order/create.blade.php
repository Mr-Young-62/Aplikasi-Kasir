@extends('layouts.app')

@section('title', 'Buat Order Baru')
@section('header', 'Buat Order Baru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('waiter.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Buat Order</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Order Baru</h1>
        <p class="text-gray-600">Masukkan detail pesanan untuk pelanggan</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form id="orderForm" method="POST" action="{{ route('waiter.order.store') }}">
            @csrf
            
            <!-- Table Selection -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="lg:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Meja <span class="text-red-500">*</span>
                    </label>
                    <select name="nomor_meja" id="no_meja" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Meja</option>
                        @foreach($availableMeja as $meja)
                            <option value="{{ $meja->nomor_meja }}" data-kapasitas="{{ $meja->kapasitas }}" data-lokasi="{{ $meja->lokasi }}">
                                Meja {{ $meja->nomor_meja }} ({{ $meja->kapasitas }} orang)
                                @if($meja->lokasi) - {{ $meja->lokasi }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('no_meja')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan Pesanan
                    </label>
                    <input type="text" name="keterangan" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Catatan khusus untuk pesanan (opsional)">
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Item Pesanan</h3>
                    <button type="button" onclick="addOrderItem()" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-plus mr-2"></i>Tambah Item
                    </button>
                </div>

                <!-- Items Container -->
                <div id="itemsContainer" class="space-y-4">
                    <!-- First item will be added by default -->
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">Total Harga</h4>
                        <p class="text-sm text-gray-600">Subtotal semua item</p>
                    </div>
                    <div class="text-right">
                        <div id="totalPrice" class="text-3xl font-bold text-blue-600">Rp. 0</div>
                        <p id="itemCount" class="text-sm text-gray-600">0 item</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('waiter.dashboard') }}" 
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i>Buat Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let itemCount = 0;
const masakans = @json($masakans);

// Add first item on page load
document.addEventListener('DOMContentLoaded', function() {
    addOrderItem();
});

function addOrderItem() {
    itemCount++;
    const container = document.getElementById('itemsContainer');
    
    const itemHtml = `
        <div class="order-item bg-white border border-gray-200 rounded-lg p-4" data-item-id="${itemCount}">
            <div class="flex justify-between items-start mb-4">
                <h5 class="font-medium text-gray-900">Item ${itemCount}</h5>
                <button type="button" onclick="removeOrderItem(${itemCount})" 
                    class="text-red-600 hover:text-red-800" title="Hapus Item">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Masakan Selection -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Masakan</label>
                    <select name="items[${itemCount}][id_masakan]" required
                        onchange="updateItemPrice(${itemCount})"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Pilih Masakan</option>
                        @foreach($masakans as $masakan)
                            <option value="{{ $masakan->id_masakan }}" 
                                data-harga="{{ $masakan->harga }}"
                                data-nama="{{ $masakan->nama_masakan }}">
                                {{ $masakan->nama_masakan }} - Rp. {{ number_format($masakan->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="items[${itemCount}][jumlah]" 
                        value="1" min="1" max="99" required
                        onchange="updateItemPrice(${itemCount})"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Subtotal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subtotal</label>
                    <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                        <span class="item-subtotal font-medium text-gray-900">Rp. 0</span>
                    </div>
                </div>
            </div>
            
            <!-- Item Notes -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Item</label>
                <input type="text" name="items[${itemCount}][keterangan]" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Catatan khusus untuk item ini (opsional)">
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
}

function removeOrderItem(itemId) {
    const item = document.querySelector(`[data-item-id="${itemId}"]`);
    if (item) {
        item.remove();
        updateTotalPrice();
    }
}

function updateItemPrice(itemId) {
    const item = document.querySelector(`[data-item-id="${itemId}"]`);
    const select = item.querySelector(`select[name="items[${itemId}][id_masakan]"]`);
    const quantity = item.querySelector(`input[name="items[${itemId}][jumlah]"]`);
    const subtotal = item.querySelector('.item-subtotal');
    
    const selectedOption = select.options[select.selectedIndex];
    const harga = selectedOption ? parseInt(selectedOption.dataset.harga) || 0 : 0;
    const jumlah = parseInt(quantity.value) || 0;
    
    const total = harga * jumlah;
    subtotal.textContent = `Rp. ${total.toLocaleString('id-ID')}`;
    
    updateTotalPrice();
}

function updateTotalPrice() {
    let total = 0;
    let count = 0;
    
    document.querySelectorAll('.order-item').forEach(item => {
        const subtotal = item.querySelector('.item-subtotal');
        const subtotalText = subtotal.textContent.replace(/[Rp.\s]/g, '').replace(/\./g, '');
        const subtotalValue = parseInt(subtotalText) || 0;
        
        if (subtotalValue > 0) {
            total += subtotalValue;
            count++;
        }
    });
    
    document.getElementById('totalPrice').textContent = `Rp. ${total.toLocaleString('id-ID')}`;
    document.getElementById('itemCount').textContent = `${count} item`;
}

// Form validation
document.getElementById('orderForm').addEventListener('submit', function(e) {
    const items = document.querySelectorAll('.order-item');
    let validItems = 0;
    
    items.forEach(item => {
        const select = item.querySelector('select');
        const quantity = item.querySelector('input[type="number"]');
        
        if (select.value && quantity.value) {
            validItems++;
        }
    });
    
    if (validItems === 0) {
        e.preventDefault();
        alert('Silakan tambahkan minimal satu item pesanan!');
        return false;
    }
    
    return true;
});
</script>
@endsection
