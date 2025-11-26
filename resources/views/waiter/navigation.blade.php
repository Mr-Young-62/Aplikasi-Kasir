<!-- Waiter Navigation -->
<div class="space-y-1">
    <a href="{{ route('waiter.dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-indigo-700 text-white">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span>Dashboard</span>
    </a>

    <div class="px-4 py-2">
        <h3 class="text-xs font-semibold text-indigo-300 uppercase tracking-wider">Order Management</h3>
    </div>
    
    <a href="{{ route('waiter.order.create') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-indigo-700 text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        <span>New Order</span>
    </a>

    <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-indigo-700 text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <span>My Orders</span>
    </a>

    <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-indigo-700 text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span>View Menu</span>
    </a>

    <div class="px-4 py-2">
        <h3 class="text-xs font-semibold text-indigo-300 uppercase tracking-wider">Settings</h3>
    </div>

    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-indigo-700 text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        <span>Profil Saya</span>
    </a>
</div>
