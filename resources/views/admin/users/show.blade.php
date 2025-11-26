@extends('layouts.app')

@section('title', 'User Details')
@section('header', 'User Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('admin.users.index') }}" class="text-gray-700 hover:text-gray-900">Users</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">{{ $user->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">User Details</h1>
                <p class="text-gray-600">View user information</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <div class="flex items-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold text-2xl">
                    {{ $user->initials() }}
                </div>
                <div class="ml-6 text-white">
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-blue-100">{{ $user->level->nama_level }}</p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">Name:</div>
                        <div class="text-sm text-gray-900">{{ $user->name }}</div>
                    </div>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">Username:</div>
                        <div class="text-sm text-gray-900">{{ $user->username }}</div>
                    </div>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">Email:</div>
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                    </div>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">Role:</div>
                        <div>
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                {{ $user->level->nama_level === 'Administrator' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->level->nama_level === 'Owner' ? 'bg-blue-100 text-blue-800' :
                                   ($user->level->nama_level === 'Kasir' ? 'bg-green-100 text-green-800' :
                                   ($user->level->nama_level === 'Waiter' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'))) }}">
                                {{ $user->level->nama_level }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">User ID:</div>
                        <div class="text-sm text-gray-900">#{{ $user->id }}</div>
                    </div>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">Email Verified:</div>
                        <div class="text-sm text-gray-900">
                            @if($user->email_verified_at)
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>{{ $user->email_verified_at->format('Y-m-d H:i') }}</span>
                            @else
                                <span class="text-red-600"><i class="fas fa-times-circle mr-1"></i>Not verified</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">Created:</div>
                        <div class="text-sm text-gray-900">{{ $user->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                    
                    <div class="flex">
                        <div class="w-32 text-sm font-medium text-gray-500">Last Updated:</div>
                        <div class="text-sm text-gray-900">{{ $user->updated_at->format('Y-m-d H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-blue-600">{{ $user->orders()->count() }}</div>
                        <div class="text-sm text-blue-600">Total Orders</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-green-600">{{ $user->transaksis()->count() }}</div>
                        <div class="text-sm text-green-600">Transactions</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <div class="text-2xl font-bold text-purple-600">{{ $user->transaksis()->where('status_transaksi', 'berhasil')->sum('total_bayar') }}</div>
                        <div class="text-sm text-purple-600">Total Revenue</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
