@extends('layouts.app')

@section('title', 'Customer Dashboard')
@section('header', 'Customer Dashboard')

@section('content')
<div class="fade-in">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-xl shadow-lg p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome, {{ auth()->user()->name }}!</h1>
                <p class="text-blue-100">Explore our delicious menu and place your order</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-4">
            <a href="{{ route('pelanggan.menu') }}" class="btn-hover bg-white text-blue-600 px-6 py-3 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                Browse Menu
            </a>
            <a href="{{ route('pelanggan.order.create') }}" class="btn-hover bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                Quick Order
            </a>
        </div>
    </div>

    <!-- Featured Menu Items -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Featured Menu</h2>
            <a href="{{ route('pelanggan.menu') }}" class="text-blue-600 hover:text-blue-700 font-medium">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredMasakan as $masakan)
                <div class="card-hover bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-orange-100 to-red-100 flex items-center justify-center">
                        @if($masakan->foto)
                            <img src="{{ asset('storage/' . $masakan->foto) }}" alt="{{ $masakan->nama_masakan }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                {{ $masakan->kategori }}
                            </span>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                Available
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $masakan->nama_masakan }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $masakan->deskripsi ?: 'Delicious dish prepared with care' }}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-lg font-bold text-blue-600">Rp. {{ number_format($masakan->harga, 0, ',', '.') }}</p>
                            <a href="{{ route('pelanggan.menu.show', $masakan->id_masakan) }}" class="btn-hover text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium mb-2">No menu items available</p>
                    <p class="text-gray-400 text-sm">Check back later for delicious options</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Browse by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @forelse($categories as $category)
                <a href="{{ route('pelanggan.menu.category', $category) }}" class="card-hover bg-white rounded-lg shadow-sm border border-gray-100 p-4 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="font-medium text-gray-900 text-sm">{{ ucfirst($category) }}</h3>
                </a>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No categories available</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="card-hover bg-gradient-to-br from-green-400 to-green-600 text-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <span class="text-2xl font-bold">Quick</span>
            </div>
            <h3 class="text-lg font-semibold mb-2">Self Order</h3>
            <p class="text-green-100 text-sm mb-4">Place your order directly without waiting for staff</p>
            <a href="{{ route('pelanggan.order.create') }}" class="btn-hover bg-white text-green-600 px-4 py-2 rounded-lg font-medium hover:bg-green-50 transition-colors inline-block">
                Order Now
            </a>
        </div>

        <div class="card-hover bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <span class="text-2xl font-bold">Full</span>
            </div>
            <h3 class="text-lg font-semibold mb-2">Browse Menu</h3>
            <p class="text-blue-100 text-sm mb-4">Explore our complete menu with detailed descriptions</p>
            <a href="{{ route('pelanggan.menu') }}" class="btn-hover bg-white text-blue-600 px-4 py-2 rounded-lg font-medium hover:bg-blue-50 transition-colors inline-block">
                View Menu
            </a>
        </div>

        <div class="card-hover bg-gradient-to-br from-purple-400 to-purple-600 text-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <span class="text-2xl font-bold">History</span>
            </div>
            <h3 class="text-lg font-semibold mb-2">My Orders</h3>
            <p class="text-purple-100 text-sm mb-4">View your order history and current orders</p>
            <a href="{{ route('pelanggan.orders') }}" class="btn-hover bg-white text-purple-600 px-4 py-2 rounded-lg font-medium hover:bg-purple-50 transition-colors inline-block">
                View Orders
            </a>
        </div>
    </div>

    <!-- Restaurant Info -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Opening Hours</h3>
                <p class="text-sm text-gray-600">Mon-Sun: 10:00 - 22:00</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Location</h3>
                <p class="text-sm text-gray-600">Jakarta, Indonesia</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Contact</h3>
                <p class="text-sm text-gray-600">+62 812-3456-7890</p>
            </div>
        </div>
    </div>
</div>
@endsection
