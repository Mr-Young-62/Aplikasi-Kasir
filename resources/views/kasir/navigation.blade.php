<!-- Kasir Navigation -->
<div class="space-y-1">
    <a href="{{ route('kasir.dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg bg-gray-800 text-white">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        <span>Dashboard</span>
    </a>

    <div class="px-4 py-2">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Transactions</h3>
    </div>
    
    <a href="{{ route('kasir.orders.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 text-gray-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <span>All Orders</span>
    </a>

    <a href="{{ route('kasir.transaksi.index') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 text-gray-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        <span>My Transactions</span>
    </a>

    <div class="px-4 py-2">
        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Settings</h3>
    </div>

    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 text-gray-700 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        <span>Profil Saya</span>
    </a>
</div>
