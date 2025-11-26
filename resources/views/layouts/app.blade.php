<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'RestoPos - Kasir Restoran') | RestoPos</title>
    <meta name="description" content="@yield('description', 'Sistem Kasir Restoran Modern dengan Table Service')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        success: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                        warning: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                        },
                        danger: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            200: '#fecaca',
                            300: '#fca5a5',
                            400: '#f87171',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        }
                    },
                    fontFamily: {
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'medium': '0 4px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                        'strong': '0 10px 40px -10px rgba(0, 0, 0, 0.15), 0 4px 25px -5px rgba(0, 0, 0, 0.1)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out',
                        'scale-in': 'scaleIn 0.3s ease-out',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        }
        
        .gradient-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        
        .gradient-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .btn-hover {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="h-full overflow-hidden bg-gray-50 font-sans">
    <div class="flex h-full">
        <!-- Modern Sidebar -->
        <aside id="sidebar" class="sidebar-transition bg-white border-r border-gray-200 w-72 min-h-screen flex flex-col shadow-soft">
            <!-- Logo Section -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-medium">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">RestoPos</h1>
                        <p class="text-sm text-gray-500">Modern Restaurant POS</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
                @auth
                    @if(auth()->user()->level && auth()->user()->level->nama_level === 'Administrator')
                        @include('admin.navigation')
                    @elseif(auth()->user()->level && auth()->user()->level->nama_level === 'Waiter')
                        @include('waiter.navigation')
                    @elseif(auth()->user()->level && auth()->user()->level->nama_level === 'Kasir')
                        @include('kasir.navigation')
                    @elseif(auth()->user()->level && auth()->user()->level->nama_level === 'Owner')
                        @include('owner.navigation')
                    @elseif(auth()->user()->level && auth()->user()->level->nama_level === 'Pelanggan')
                        @include('pelanggan.navigation')
                    @endif
                @endauth
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-gray-100">
                <div class="flex items-center space-x-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="relative">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center shadow-medium">
                            <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name, 0, 2) }}</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-success-500 rounded-full border-2 border-white"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->level->nama_level ?? 'User' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-hover p-2 rounded-lg hover:bg-gray-200 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Modern Header -->
            <header class="glass-effect border-b border-gray-200">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <button id="sidebarToggle" class="lg:hidden btn-hover p-3 rounded-xl hover:bg-gray-100">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">@yield('header', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500">Welcome back, {{ auth()->user()->name }}!</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="hidden md:flex items-center space-x-2 bg-gray-100 rounded-xl px-4 py-2">
                            <i class="fas fa-search text-gray-400"></i>
                            <input type="text" placeholder="Search..." class="bg-transparent outline-none text-sm text-gray-600 w-48">
                        </div>
                        
                        <!-- Clock -->
                        <div class="hidden md:flex items-center space-x-2 bg-gray-100 rounded-xl px-4 py-2">
                            <i class="fas fa-clock text-gray-400"></i>
                            <span id="clock" class="text-sm font-medium text-gray-600">{{ now()->format('H:i:s') }}</span>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="relative">
                            <button class="btn-hover p-3 rounded-xl hover:bg-gray-100 relative">
                                <i class="fas fa-bell text-gray-600"></i>
                                <span class="absolute top-2 right-2 w-2 h-2 bg-danger-500 rounded-full"></span>
                            </button>
                        </div>
                        
                        <!-- Settings -->
                        <button class="btn-hover p-3 rounded-xl hover:bg-gray-100">
                            <i class="fas fa-cog text-gray-600"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto bg-gray-50 p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="animate-fade-in mb-6 bg-success-50 border border-success-200 text-success-800 px-6 py-4 rounded-xl flex items-center space-x-3 shadow-soft">
                        <div class="w-10 h-10 bg-success-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-success-600"></i>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="animate-fade-in mb-6 bg-danger-50 border border-danger-200 text-danger-800 px-6 py-4 rounded-xl flex items-center space-x-3 shadow-soft">
                        <div class="w-10 h-10 bg-danger-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-danger-600"></i>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="animate-fade-in mb-6 bg-warning-50 border border-warning-200 text-warning-800 px-6 py-4 rounded-xl shadow-soft">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-warning-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-warning-600"></i>
                            </div>
                            <span class="font-semibold">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-sm ml-8">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Main Content Area -->
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <script>
        // Clock update
        function updateClock() {
            const now = new Date();
            const clock = document.getElementById('clock');
            if (clock) {
                clock.textContent = now.toLocaleTimeString('en-US', { 
                    hour12: false, 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                });
            }
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Mobile sidebar toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
                sidebarOverlay.classList.toggle('hidden');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            });
        }

        // Initialize sidebar state for mobile
        if (window.innerWidth < 1024 && sidebar) {
            sidebar.classList.add('-translate-x-full');
        }

        // Add smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
