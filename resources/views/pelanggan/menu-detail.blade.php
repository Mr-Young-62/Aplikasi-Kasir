@extends('layouts.app')

@section('title', $masakan->nama_masakan)
@section('header', 'Detail Menu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <div class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('pelanggan.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('pelanggan.menu') }}" class="hover:text-blue-600">Menu</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">{{ $masakan->nama_masakan }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Images -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-96 bg-gray-100">
                    @if($masakan->gambar)
                        <img src="{{ asset('storage/' . $masakan->gambar) }}" 
                             alt="{{ $masakan->nama_masakan }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-utensils text-gray-400 text-6xl"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Status & Category -->
                <div class="p-4 flex justify-between items-center">
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800">
                        {{ $masakan->kategori }}
                    </span>
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                        {{ $masakan->status_masakan === 'tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $masakan->status_masakan === 'tersedia' ? 'Tersedia' : 'Habis' }}
                    </span>
                </div>
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $masakan->nama_masakan }}</h1>
                
                <div class="mb-6">
                    <div class="text-3xl font-bold text-blue-600 mb-2">
                        Rp. {{ number_format($masakan->harga, 0, ',', '.') }}
                    </div>
                    <p class="text-gray-600">Harga per porsi</p>
                </div>

                @if($masakan->deskripsi)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $masakan->deskripsi }}</p>
                    </div>
                @endif

                <!-- Add to Cart Section -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <label class="text-sm font-medium text-gray-700">Jumlah:</label>
                        <div class="flex items-center space-x-2">
                            <button onclick="decreaseQuantity()" 
                                class="w-10 h-10 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" id="quantity" value="1" min="1" max="99" 
                                class="w-20 text-center border border-gray-300 rounded-lg">
                            <button onclick="increaseQuantity()" 
                                class="w-10 h-10 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        @if($masakan->status_masakan === 'tersedia')
                            <button onclick="addToCart()" 
                                class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                <i class="fas fa-shopping-cart mr-2"></i>Tambah ke Keranjang
                            </button>
                            <button onclick="buyNow()" 
                                class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class="fas fa-bolt mr-2"></i>Beli Sekarang
                            </button>
                        @else
                            <button disabled class="flex-1 px-6 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                                <i class="fas fa-times mr-2"></i>Sedang Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Product Details -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Produk</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kategori</span>
                        <span class="font-medium text-gray-900">{{ $masakan->kategori }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="font-medium text-gray-900">{{ $masakan->status_masakan === 'tersedia' ? 'Tersedia' : 'Habis' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Harga</span>
                        <span class="font-medium text-gray-900">Rp. {{ number_format($masakan->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-3 border-t border-gray-200">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total</span>
                            <span id="totalPrice" class="font-bold text-lg text-blue-600">Rp. {{ number_format($masakan->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedMasakan->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Menu Terkait</h3>
                    <div class="space-y-4">
                        @foreach($relatedMasakan as $related)
                            <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 cursor-pointer"
                                 onclick="window.location.href='{{ route("pelanggan.menu.show", $related->id_masakan) }}'">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($related->gambar)
                                        <img src="{{ asset('storage/' . $related->gambar) }}" 
                                             alt="{{ $related->nama_masakan }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-utensils text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $related->nama_masakan }}</h4>
                                    <p class="text-sm text-blue-600 font-medium">Rp. {{ number_format($related->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Help Section -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-medium text-blue-900 mb-2">Butuh Bantuan?</h4>
                <p class="text-sm text-blue-700 mb-3">
                    Hubungi waiter kami untuk informasi lebih lanjut tentang menu ini.
                </p>
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                    <i class="fas fa-phone mr-2"></i>Hubungi Waiter
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const price = {{ $masakan->harga }};
const masakanId = {{ $masakan->id_masakan }};
const masakanName = '{{ $masakan->nama_masakan }}';

function updateTotal() {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    const total = price * quantity;
    document.getElementById('totalPrice').textContent = `Rp. ${total.toLocaleString('id-ID')}`;
}

function increaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    if (currentValue < 99) {
        input.value = currentValue + 1;
        updateTotal();
    }
}

function decreaseQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value) || 1;
    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateTotal();
    }
}

function addToCart() {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    
    // Get existing cart from localStorage or create new
    let cart = JSON.parse(localStorage.getItem('pelangganCart') || '[]');
    
    // Check if item already exists
    const existingItem = cart.find(item => item.id === masakanId);
    
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({
            id: masakanId,
            name: masakanName,
            price: price,
            quantity: quantity
        });
    }
    
    // Save cart to localStorage
    localStorage.setItem('pelangganCart', JSON.stringify(cart));
    
    // Show notification
    showNotification(`${quantity}x ${masakanName} ditambahkan ke keranjang`);
    
    // Update cart count if on menu page
    updateCartCount();
}

function buyNow() {
    // Add to cart and redirect to order page
    addToCart();
    setTimeout(() => {
        window.location.href = '{{ route("pelanggan.order.create") }}';
    }, 500);
}

function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('pelangganCart') || '[]');
    const count = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    // Update cart count badge if it exists
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
        if (count > 0) {
            cartCount.textContent = count;
            cartCount.classList.remove('hidden');
        } else {
            cartCount.classList.add('hidden');
        }
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTotal();
    updateCartCount();
    
    // Add input event listener
    document.getElementById('quantity').addEventListener('input', updateTotal);
});
</script>
@endsection
