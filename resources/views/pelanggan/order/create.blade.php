@extends('layouts.app')

@section('title', 'Buat Order')
@section('header', 'Buat Order')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Buat Order</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Order</h1>
        <p class="text-gray-600">Lengkapi detail pesanan Anda</p>
    </div>

    <!-- Order Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Item Pesanan</h3>
                    <a href="{{ route('pelanggan.menu') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-plus mr-1"></i>Tambah Item
                    </a>
                </div>

                <div id="orderItems" class="space-y-4">
                    <!-- Items will be loaded here -->
                </div>

                <div id="emptyCart" class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 mb-4">Keranjang belanja masih kosong</p>
                    <a href="{{ route('pelanggan.menu') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-utensils"></i>
                        <span>Lihat Menu</span>
                    </a>
                </div>

                <!-- Order Summary -->
                <div id="orderSummary" class="hidden mt-6 pt-6 border-t border-gray-200">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span id="subtotal" class="text-gray-900">Rp. 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Pajak (10%)</span>
                            <span id="tax" class="text-gray-900">Rp. 0</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-blue-600 pt-3 border-t border-gray-200">
                            <span>Total</span>
                            <span id="total">Rp. 0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Detail Pesanan</h3>
                
                <form method="POST" action="{{ route('pelanggan.order.store') }}" id="orderForm">
                    @csrf
                    
                    <!-- Table Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Meja <span class="text-red-500">*</span>
                        </label>
                        <select name="nomor_meja" id="nomor_meja" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Pilih Meja</option>
                            @foreach($availableMeja as $meja)
                                <option value="{{ $meja->nomor_meja }}" data-kapasitas="{{ $meja->kapasitas }}">
                                    Meja {{ $meja->nomor_meja }} ({{ $meja->kapasitas }} orang)
                                    @if($meja->lokasi) - {{ $meja->lokasi }} @endif
                                </option>
                            @endforeach
                        </select>
                        @error('nomor_meja')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Notes -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Pesanan
                        </label>
                        <textarea name="keterangan" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="Catatan khusus untuk pesanan (opsional)"></textarea>
                        <p class="mt-1 text-xs text-gray-500">Catatan akan ditambahkan ke pesanan Anda</p>
                    </div>

                    <!-- Order Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Pesanan
                        </label>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                            <div class="flex items-center space-x-2">
                                <i class="fas fa-mobile-alt text-blue-600"></i>
                                <div>
                                    <p class="text-sm font-medium text-blue-900">Self-Order</p>
                                    <p class="text-xs text-blue-700">Pesanan akan langsung dikirim ke waiter</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Items Field -->
                    <input type="hidden" name="items" id="itemsField">

                    <!-- Submit Button -->
                    <div class="space-y-3">
                        <button type="submit" id="submitBtn" disabled
                            class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed">
                            <i class="fas fa-check mr-2"></i>Buat Pesanan
                        </button>
                        
                        <a href="{{ route('pelanggan.menu') }}" 
                           class="w-full block px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 text-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Menu
                        </a>
                    </div>
                </form>
            </div>

            <!-- Info Card -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-yellow-800">Informasi Penting</p>
                        <p class="text-sm text-yellow-700 mt-1">
                            Pastikan semua item pesanan sudah benar sebelum membuat order. 
                            Pesanan yang sudah dibuat tidak dapat diubah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];

function loadCart() {
    // Load cart from localStorage
    const savedCart = localStorage.getItem('pelangganCart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        displayCart();
        updateSummary();
    }
}

function displayCart() {
    const orderItems = document.getElementById('orderItems');
    const emptyCart = document.getElementById('emptyCart');
    const orderSummary = document.getElementById('orderSummary');
    const submitBtn = document.getElementById('submitBtn');
    
    if (cart.length === 0) {
        orderItems.innerHTML = '';
        emptyCart.style.display = 'block';
        orderSummary.classList.add('hidden');
        submitBtn.disabled = true;
    } else {
        emptyCart.style.display = 'none';
        orderSummary.classList.remove('hidden');
        submitBtn.disabled = false;
        
        orderItems.innerHTML = cart.map((item, index) => `
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">${item.name}</h4>
                        <p class="text-sm text-gray-600">Rp. ${item.price.toLocaleString('id-ID')} per porsi</p>
                    </div>
                    <button onclick="removeItem(${index})" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <button onclick="updateQuantity(${index}, ${item.quantity - 1})" 
                            class="w-8 h-8 bg-white border border-gray-300 rounded hover:bg-gray-50">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <input type="number" value="${item.quantity}" min="1" max="99" readonly
                            class="w-16 text-center bg-white border border-gray-300 rounded">
                        <button onclick="updateQuantity(${index}, ${item.quantity + 1})" 
                            class="w-8 h-8 bg-white border border-gray-300 rounded hover:bg-gray-50">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                    <div class="font-medium text-gray-900">
                        Rp. ${(item.price * item.quantity).toLocaleString('id-ID')}
                    </div>
                </div>
            </div>
        `).join('');
    }
}

function updateQuantity(index, quantity) {
    if (quantity >= 1 && quantity <= 99) {
        cart[index].quantity = quantity;
        localStorage.setItem('pelangganCart', JSON.stringify(cart));
        displayCart();
        updateSummary();
    }
}

function removeItem(index) {
    if (confirm('Hapus item ini dari keranjang?')) {
        cart.splice(index, 1);
        localStorage.setItem('pelangganCart', JSON.stringify(cart));
        displayCart();
        updateSummary();
    }
}

function updateSummary() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = Math.round(subtotal * 0.1);
    const total = subtotal + tax;
    
    document.getElementById('subtotal').textContent = `Rp. ${subtotal.toLocaleString('id-ID')}`;
    document.getElementById('tax').textContent = `Rp. ${tax.toLocaleString('id-ID')}`;
    document.getElementById('total').textContent = `Rp. ${total.toLocaleString('id-ID')}`;
}

function prepareItemsField() {
    const itemsField = document.getElementById('itemsField');
    const items = cart.map(item => ({
        id_masakan: item.id,
        jumlah: item.quantity,
        keterangan: ''
    }));
    itemsField.value = JSON.stringify(items);
}

// Form submission
document.getElementById('orderForm').addEventListener('submit', function(e) {
    if (cart.length === 0) {
        e.preventDefault();
        alert('Keranjang masih kosong!');
        return false;
    }
    
    const nomorMeja = document.getElementById('nomor_meja').value;
    if (!nomorMeja) {
        e.preventDefault();
        alert('Silakan pilih meja!');
        return false;
    }
    
    prepareItemsField();
    
    // Clear cart after successful submission
    localStorage.removeItem('pelangganCart');
    
    return true;
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
});
</script>
@endsection
