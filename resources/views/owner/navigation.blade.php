<!-- Owner Navigation -->
<div class="space-y-1">
  <!-- Dashboard -->
  <a href="{{ route('owner.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all group">
    <i class="fas fa-home w-5 text-center group-hover:scale-110 transition-transform"></i>
    <span class="font-medium">Dashboard</span>
  </a>

  <!-- Reports Dropdown -->
  <div class="space-y-1">
    <button class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all group">
      <i class="fas fa-chart-line w-5 text-center group-hover:scale-110 transition-transform"></i>
      <span class="font-medium">Laporan</span>
      <i class="fas fa-chevron-down ml-auto text-xs"></i>
    </button>
    <div class="ml-8 space-y-1">
      <a href="{{ route('owner.laporan.penjualan') }}" class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all">
        <i class="fas fa-shopping-cart w-4 text-center"></i>
        <span>Laporan Penjualan</span>
      </a>
      <a href="{{ route('owner.laporan.masakan') }}" class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all">
        <i class="fas fa-utensils w-4 text-center"></i>
        <span>Laporan Masakan</span>
      </a>
      <a href="{{ route('owner.laporan.waiter') }}" class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all">
        <i class="fas fa-user-tie w-4 text-center"></i>
        <span>Laporan Waiter</span>
      </a>
      <a href="{{ route('owner.laporan.pelanggan') }}" class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all">
        <i class="fas fa-users w-4 text-center"></i>
        <span>Laporan Pelanggan</span>
      </a>
    </div>
  </div>

  <!-- Analytics -->
  <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all group">
    <i class="fas fa-chart-pie w-5 text-center group-hover:scale-110 transition-transform"></i>
    <span class="font-medium">Analytics</span>
  </a>

  <!-- Settings -->
  <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 transition-all group">
    <i class="fas fa-cog w-5 text-center group-hover:scale-110 transition-transform"></i>
    <span class="font-medium">Pengaturan</span>
  </a>
    </div>

    <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg hover:bg-indigo-700 text-white transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        <span>Profil Saya</span>
    </a>
</div>
