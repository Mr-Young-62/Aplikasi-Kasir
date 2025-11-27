@extends('layouts.app')

@section('title', 'Menu Restoran')
@section('header', 'Menu Restoran')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Menu Kami</h1>
        <p class="text-gray-600">Pilih dari berbagai pilihan masakan lezat</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <form method="GET" action="{{ route('pelanggan.menu.search') }}" class="flex">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari masakan..." 
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Category Filter -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pelanggan.menu') }}" 
                    class="px-4 py-2 rounded-lg border transition-colors
                        {{ !isset($kategori) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('pelanggan.menu.category', $category) }}" 
                        class="px-4 py-2 rounded-lg border transition-colors
                            {{ (isset($kategori) && $kategori == $category) ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                        {{ ucfirst($category) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Results Info -->
    @if(isset($search) || isset($kategori))
        <div class="mb-6">
            <p class="text-gray-600">
                @if(isset($search))
                    Menampilkan hasil pencarian untuk <strong>"{{ $search }}"</strong>
                @else
                    Kategori: <strong>{{ ucfirst($kategori) }}</strong>
                @endif
                - {{ $masakans->count() }} item ditemukan
            </p>
        </div>
    @endif

    <!-- Menu Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @forelse($masakans as $masakan)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <!-- Image -->
                <div class="h-48 bg-gray-100 relative">
                    @if($masakan->gambar)
                        <img src="{{ asset('storage/' . $masakan->gambar) }}" 
                             alt="{{ $masakan->nama_masakan }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-utensils text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    
                    <!-- Status Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                            {{ $masakan->status_masakan === 'tersedia' ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                    
                    <!-- Category Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                            {{ $masakan->kategori }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $masakan->nama_masakan }}</h3>
                    
                    @if($masakan->deskripsi)
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ Str::limit($masakan->deskripsi, 80) }}</p>
                    @endif
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-2xl font-bold text-blue-600">
                            Rp. {{ number_format($masakan->harga, 0, ',', '.') }}
                        </div>
                        @if($masakan->status_masakan === 'tersedia')
                            <button onclick="addToCart({{ $masakan->id_masakan }}, '{{ $masakan->nama_masakan }}', {{ $masakan->harga }})" 
                                class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                                <i class="fas fa-plus mr-1"></i>Tambah
                            </button>
                        @else
                            <button disabled class="px-3 py-1 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                                <i class="fas fa-times mr-1"></i>Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>
                <p class="text-gray-500">Tidak ada masakan ditemukan</p>
                <p class="text-gray-400 text-sm mt-2">Coba kata kunci atau kategori lain</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($masakans->hasPages())
        <div class="bg-white rounded-xl shadow-lg p-6">
            {{ $masakans->links() }}
        </div>
    @endif
</div>

<!-- Cart Sidebar -->
<div id="cartSidebar" class="fixed inset-y-0 right-0 w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
    <div class="h-full flex flex-col">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-4">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold">Keranjang Belanja</h3>
                <button onclick="toggleCart()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4">
            <div id="cartItems" class="space-y-3">
                <!-- Cart items will be added here -->
            </div>
            
            <div id="emptyCart" class="text-center py-8">
                <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-3"></i>
                <p class="text-gray-500">Keranjang masih kosong</p>
            </div>
        </div>

        <!-- Cart Footer -->
        <div class="border-t border-gray-200 p-4">
            <div class="flex justify-between items-center mb-4">
                <span class="text-lg font-semibold">Total:</span>
                <span id="cartTotal" class="text-2xl font-bold text-blue-600">Rp. 0</span>
            </div>
            
            <div class="space-y-3">
                <button onclick="proceedToOrder()" 
                    class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed"
                    id="proceedBtn" disabled>
                    <i class="fas fa-arrow-right mr-2"></i>Lanjut ke Order
                </button>
                <button onclick="clearCart()" 
                    class="w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    <i class="fas fa-trash mr-2"></i>Kosongkan Keranjang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cart Toggle Button -->
<button onclick="toggleCart()" 
    class="fixed bottom-6 right-6 w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 z-40 flex items-center justify-center">
    <i class="fas fa-shopping-cart"></i>
    <span id="cartCount" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white text-xs rounded-full flex items-center justify-center hidden">0</span>
</button>

<script>
let cart = [];

function toggleCart() {
    const sidebar = document.getElementById('cartSidebar');
    sidebar.classList.toggle('translate-x-full');
}

function addToCart(id, name, price) {
    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            id: id,
            name: name,
            price: price,
            quantity: 1
        });
    }
    
    updateCart();
    
    // Show notification
    showNotification(`${name} ditambahkan ke keranjang`);
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    updateCart();
}

function updateQuantity(id, quantity) {
    const item = cart.find(item => item.id === id);
    if (item) {
        item.quantity = Math.max(1, parseInt(quantity) || 1);
        updateCart();
    }
}

function updateCart() {
    const cartItems = document.getElementById('cartItems');
    const emptyCart = document.getElementById('emptyCart');
    const cartTotal = document.getElementById('cartTotal');
    const cartCount = document.getElementById('cartCount');
    const proceedBtn = document.getElementById('proceedBtn');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '';
        emptyCart.style.display = 'block';
        cartTotal.textContent = 'Rp. 0';
        cartCount.classList.add('hidden');
        proceedBtn.disabled = true;
    } else {
        emptyCart.style.display = 'none';
        cartCount.classList.remove('hidden');
        cartCount.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
        proceedBtn.disabled = false;
        
        let total = 0;
        cartItems.innerHTML = cart.map(item => {
            const subtotal = item.price * item.quantity;
            total += subtotal;
            
            return `
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">${item.name}</h4>
                            <p class="text-sm text-gray-600">Rp. ${item.price.toLocaleString('id-ID')}</p>
                        </div>
                        <button onclick="removeFromCart(${item.id})" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" 
                                class="w-8 h-8 bg-white border border-gray-300 rounded hover:bg-gray-50">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <input type="number" value="${item.quantity}" min="1" max="99" 
                                onchange="updateQuantity(${item.id}, this.value)"
                                class="w-16 text-center border border-gray-300 rounded">
                            <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})" 
                                class="w-8 h-8 bg-white border border-gray-300 rounded hover:bg-gray-50">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                        <div class="font-medium text-gray-900">
                            Rp. ${subtotal.toLocaleString('id-ID')}
                        </div>
                    </div>
                </div>
            `;
        }).join('');
        
        cartTotal.textContent = `Rp. ${total.toLocaleString('id-ID')}`;
    }
}

function clearCart() {
    if (confirm('Kosongkan keranjang belanja?')) {
        cart = [];
        updateCart();
        showNotification('Keranjang dikosongkan');
    }
}

function proceedToOrder() {
    if (cart.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }
    
    // Store cart in localStorage for order page
    localStorage.setItem('pelangganCart', JSON.stringify(cart));
    
    // Redirect to order page
    window.location.href = '{{ route("pelanggan.order.create") }}';
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

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCart();
});
</script>
@endsection
