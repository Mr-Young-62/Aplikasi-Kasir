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
        
        /* Dark mode specific styles */
        .dark {
            color-scheme: dark;
        }
        
        .dark body {
            background-color: #0f172a;
            color: #e2e8f0;
        }
        
        .dark .bg-white {
            background-color: #1e293b !important;
            color: #e2e8f0;
        }
        
        .dark .bg-gray-50 {
            background-color: #0f172a !important;
        }
        
        .dark .bg-gray-100 {
            background-color: #1e293b !important;
        }
        
        .dark .bg-gray-200 {
            background-color: #334155 !important;
        }
        
        .dark .text-gray-900 {
            color: #f1f5f9 !important;
        }
        
        .dark .text-gray-800 {
            color: #e2e8f0 !important;
        }
        
        .dark .text-gray-700 {
            color: #cbd5e1 !important;
        }
        
        .dark .text-gray-600 {
            color: #94a3b8 !important;
        }
        
        .dark .text-gray-500 {
            color: #64748b !important;
        }
        
        .dark .border-gray-200 {
            border-color: #334155 !important;
        }
        
        .dark .border-gray-100 {
            border-color: #1e293b !important;
        }
        
        .dark .glass-effect {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .dark .sidebar-transition.visible {
            background: #1e293b !important;
        }
        
        .dark .hover\:bg-gray-100:hover {
            background-color: #334155 !important;
        }
        
        .dark .hover\:bg-gray-50:hover {
            background-color: #1e293b !important;
        }
        
        .dark .hover\:text-gray-900:hover {
            color: #f1f5f9 !important;
        }
        
        .dark .shadow-soft {
            box-shadow: 0 2px 15px -3px rgba(0, 0, 0, 0.3), 0 10px 20px -2px rgba(0, 0, 0, 0.2) !important;
        }
        
        .dark .shadow-medium {
            box-shadow: 0 4px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2) !important;
        }
        
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
        
        .sidebar-transition.visible {
            display: flex !important;
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
        
        /* Theme dropdown animation */
        #themeDropdown {
            transition: all 0.2s ease-in-out;
            transform-origin: top right;
        }
        
        #themeDropdown.show {
            opacity: 1;
            transform: scale(1);
        }
        
        #themeDropdown.hidden {
            opacity: 0;
            transform: scale(0.95);
        }
        
        /* Notification dropdown animation */
        #notificationDropdown {
            transition: all 0.2s ease-in-out;
            transform-origin: top right;
        }
        
        #notificationDropdown.show {
            opacity: 1;
            transform: scale(1);
        }
        
        #notificationDropdown.hidden {
            opacity: 0;
            transform: scale(0.95);
        }
        
        /* Notification animations */
        .notification-item {
            transition: all 0.2s ease-in-out;
        }
        
        .notification-item:hover {
            transform: translateX(2px);
        }
        
        /* Toast notifications */
        .toast-notification {
            animation: slideInRight 0.3s ease-out;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Notification badge pulse animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .notification-pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body class="h-full overflow-hidden bg-gray-50 dark:bg-slate-900 font-sans transition-colors duration-300">
    <div class="flex h-full">
        <!-- Modern Sidebar -->
        <aside id="sidebar" class="sidebar-transition bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700 w-72 min-h-screen flex flex-col shadow-soft visible">
            <!-- Logo Section -->
            <div class="p-6 border-b border-gray-100 dark:border-slate-700">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-medium">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">RestoPos</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Modern Restaurant POS</p>
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
            <div class="p-4 border-t border-gray-100 dark:border-slate-700">
                <div class="flex items-center space-x-3 p-3 rounded-xl bg-gray-50 dark:bg-slate-700 hover:bg-gray-100 dark:hover:bg-slate-600 transition-colors">
                    <div class="relative">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-full flex items-center justify-center shadow-medium">
                            <span class="text-sm font-semibold text-white">{{ substr(auth()->user()->name, 0, 2) }}</span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-success-500 rounded-full border-2 border-white dark:border-slate-800"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->level->nama_level ?? 'User' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-hover p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Modern Header -->
            <header class="glass-effect border-b border-gray-200 dark:border-slate-700">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <button id="sidebarToggle" class="lg:hidden btn-hover p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700">
                            <i class="fas fa-bars text-gray-600 dark:text-gray-300"></i>
                        </button>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">@yield('header', 'Dashboard')</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Welcome back, {{ auth()->user()->name }}!</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="hidden md:flex items-center space-x-2 bg-gray-100 dark:bg-slate-700 rounded-xl px-4 py-2">
                            <i class="fas fa-search text-gray-400 dark:text-gray-400"></i>
                            <input type="text" placeholder="Search..." class="bg-transparent outline-none text-sm text-gray-600 dark:text-gray-300 w-48">
                        </div>
                        
                        <!-- Clock -->
                        <div class="hidden md:flex items-center space-x-2 bg-gray-100 dark:bg-slate-700 rounded-xl px-4 py-2">
                            <i class="fas fa-clock text-gray-400 dark:text-gray-400"></i>
                            <span id="clock" class="text-sm font-medium text-gray-600 dark:text-gray-300">{{ now()->format('H:i:s') }}</span>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="relative">
                            <button id="notificationToggle" class="btn-hover p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 relative">
                                <i class="fas fa-bell text-gray-600 dark:text-gray-300"></i>
                                <span id="notificationBadge" class="absolute top-2 right-2 w-2 h-2 bg-danger-500 rounded-full hidden"></span>
                                <span id="notificationCount" class="absolute -top-1 -right-1 bg-danger-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center hidden">0</span>
                            </button>
                            
                            <!-- Notifications Dropdown -->
                            <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-600 hidden z-50">
                                <div class="p-4 border-b border-gray-200 dark:border-slate-700">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                        <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                            Mark all as read
                                        </button>
                                    </div>
                                </div>
                                
                                <div id="notificationList" class="max-h-96 overflow-y-auto">
                                    <!-- Notifications will be loaded here -->
                                    <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                        <p class="text-sm">No notifications</p>
                                    </div>
                                </div>
                                
                                <div class="p-3 border-t border-gray-200 dark:border-slate-700">
                                    <button onclick="viewAllNotifications()" class="w-full text-center text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                        View all notifications
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Theme Toggle -->
                        <div class="relative">
                            <button id="themeToggle" class="btn-hover p-3 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700 group">
                                <i id="themeIcon" class="fas fa-sun text-yellow-500 group-hover:text-yellow-600"></i>
                            </button>
                            
                            <!-- Theme Dropdown -->
                            <div id="themeDropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-200 dark:border-slate-600 hidden z-50">
                                <div class="p-2">
                                    <button onclick="setTheme('light')" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-left">
                                        <i class="fas fa-sun text-yellow-500"></i>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Light</span>
                                    </button>
                                    <button onclick="setTheme('dark')" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-left">
                                        <i class="fas fa-moon text-purple-500"></i>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Dark</span>
                                    </button>
                                    <button onclick="setTheme('system')" class="w-full flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-left">
                                        <i class="fas fa-desktop text-blue-500"></i>
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">System</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto bg-gray-50 dark:bg-slate-900 p-8">
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
        // Theme Management
        const THEMES = {
            light: 'light',
            dark: 'dark',
            system: 'system'
        };

        // Get saved theme or default to system
        function getSavedTheme() {
            return localStorage.getItem('theme') || THEMES.system;
        }

        // Update theme icon based on current theme
        function updateThemeIcon(theme) {
            const icon = document.getElementById('themeIcon');
            if (!icon) return;

            switch(theme) {
                case THEMES.light:
                    icon.className = 'fas fa-sun text-yellow-500 group-hover:text-yellow-600';
                    break;
                case THEMES.dark:
                    icon.className = 'fas fa-moon text-purple-500 group-hover:text-purple-600';
                    break;
                case THEMES.system:
                    icon.className = 'fas fa-desktop text-blue-500 group-hover:text-blue-600';
                    break;
            }
        }

        // Apply theme to document
        function applyTheme(theme) {
            const html = document.documentElement;
            
            if (theme === THEMES.system) {
                // Remove manual theme classes and let system preference work
                html.classList.remove('light', 'dark');
                // Check system preference
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    html.classList.add('dark');
                }
            } else {
                // Remove system preference and apply manual theme
                html.classList.remove('dark');
                if (theme === THEMES.dark) {
                    html.classList.add('dark');
                }
            }
            
            updateThemeIcon(theme);
        }

        // Set theme and save to localStorage
        function setTheme(theme) {
            localStorage.setItem('theme', theme);
            applyTheme(theme);
            
            // Close dropdown
            const dropdown = document.getElementById('themeDropdown');
            if (dropdown) {
                dropdown.classList.add('hidden');
            }
        }

        // Toggle theme dropdown
        function toggleThemeDropdown() {
            const dropdown = document.getElementById('themeDropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Close dropdown when clicking outside
        function closeThemeDropdown(event) {
            const dropdown = document.getElementById('themeDropdown');
            const toggle = document.getElementById('themeToggle');
            
            if (dropdown && !dropdown.contains(event.target) && !toggle.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }

        // Notification Management
        class NotificationManager {
            constructor() {
                this.notifications = [];
                this.unreadCount = 0;
                this.init();
            }

            init() {
                // Load notifications from localStorage
                const saved = localStorage.getItem('notifications');
                if (saved) {
                    this.notifications = JSON.parse(saved);
                    this.updateUI();
                }

                // Simulate real-time notifications
                this.startPolling();
            }

            startPolling() {
                // Check for new notifications every 30 seconds
                setInterval(() => {
                    this.checkNewNotifications();
                }, 30000);
            }

            checkNewNotifications() {
                // Simulate server check for new notifications
                // In real app, this would be an API call
                const mockNotifications = this.generateMockNotifications();
                
                mockNotifications.forEach(notification => {
                    if (!this.notifications.find(n => n.id === notification.id)) {
                        this.addNotification(notification);
                    }
                });
            }

            generateMockNotifications() {
                const notifications = [];
                const now = new Date();
                
                // Generate different types of notifications based on user role
                const userRole = '{{ auth()->user()->level->nama_level ?? "User" }}';
                
                if (userRole === 'Waiter') {
                    notifications.push({
                        id: 'order-' + Date.now(),
                        type: 'order',
                        title: 'New Order Received',
                        message: 'Table 5 has placed a new order',
                        time: now.toISOString(),
                        read: false,
                        icon: 'fa-shopping-cart',
                        color: 'blue'
                    });
                } else if (userRole === 'Kasir') {
                    notifications.push({
                        id: 'payment-' + Date.now(),
                        type: 'payment',
                        title: 'Payment Ready',
                        message: 'Order #1234 is ready for payment',
                        time: now.toISOString(),
                        read: false,
                        icon: 'fa-credit-card',
                        color: 'green'
                    });
                } else if (userRole === 'Owner') {
                    notifications.push({
                        id: 'sales-' + Date.now(),
                        type: 'sales',
                        title: 'Daily Sales Update',
                        message: 'Today\'s sales reached Rp 2,500,000',
                        time: now.toISOString(),
                        read: false,
                        icon: 'fa-chart-line',
                        color: 'purple'
                    });
                }

                // Random chance for system notifications
                if (Math.random() > 0.7) {
                    notifications.push({
                        id: 'system-' + Date.now(),
                        type: 'system',
                        title: 'System Update',
                        message: 'New features available in dashboard',
                        time: now.toISOString(),
                        read: false,
                        icon: 'fa-cog',
                        color: 'gray'
                    });
                }

                return notifications;
            }

            addNotification(notification) {
                this.notifications.unshift(notification);
                this.saveToStorage();
                this.updateUI();
                this.showNotificationToast(notification);
            }

            showNotificationToast(notification) {
                // Create toast notification
                const toast = document.createElement('div');
                toast.className = `fixed top-20 right-4 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg p-4 z-50 transform translate-x-full transition-transform duration-300`;
                toast.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <div class="w-10 h-10 bg-${notification.color}-100 dark:bg-${notification.color}-900 rounded-full flex items-center justify-center">
                            <i class="fas ${notification.icon} text-${notification.color}-600 dark:text-${notification.color}-400"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">${notification.title}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">${notification.message}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">${this.formatTime(notification.time)}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;

                document.body.appendChild(toast);

                // Animate in
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);

                // Remove after 5 seconds
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (toast.parentElement) {
                            toast.remove();
                        }
                    }, 300);
                }, 5000);
            }

            markAsRead(notificationId) {
                const notification = this.notifications.find(n => n.id === notificationId);
                if (notification) {
                    notification.read = true;
                    this.saveToStorage();
                    this.updateUI();
                }
            }

            markAllAsRead() {
                this.notifications.forEach(n => n.read = true);
                this.saveToStorage();
                this.updateUI();
            }

            deleteNotification(notificationId) {
                this.notifications = this.notifications.filter(n => n.id !== notificationId);
                this.saveToStorage();
                this.updateUI();
            }

            updateUI() {
                this.updateBadge();
                this.renderNotifications();
            }

            updateBadge() {
                const unreadCount = this.notifications.filter(n => !n.read).length;
                const badge = document.getElementById('notificationBadge');
                const count = document.getElementById('notificationCount');

                if (unreadCount > 0) {
                    badge?.classList.remove('hidden');
                    badge?.classList.add('notification-pulse');
                    if (unreadCount > 1) {
                        count.textContent = unreadCount > 9 ? '9+' : unreadCount;
                        count?.classList.remove('hidden');
                        badge?.classList.add('hidden');
                        badge?.classList.remove('notification-pulse');
                        count?.classList.add('notification-pulse');
                    } else {
                        count?.classList.add('hidden');
                        count?.classList.remove('notification-pulse');
                        badge?.classList.remove('hidden');
                    }
                } else {
                    badge?.classList.add('hidden');
                    badge?.classList.remove('notification-pulse');
                    count?.classList.add('hidden');
                    count?.classList.remove('notification-pulse');
                }
            }

            renderNotifications() {
                const list = document.getElementById('notificationList');
                if (!list) return;

                if (this.notifications.length === 0) {
                    list.innerHTML = `
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-bell-slash text-2xl mb-2"></i>
                            <p class="text-sm">No notifications</p>
                        </div>
                    `;
                    return;
                }

                const html = this.notifications.map(notification => `
                    <div class="notification-item ${notification.read ? 'opacity-60' : ''} hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors cursor-pointer" onclick="notificationManager.markAsRead('${notification.id}')">
                        <div class="p-4 border-b border-gray-100 dark:border-slate-700 last:border-b-0">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 bg-${notification.color}-100 dark:bg-${notification.color}-900 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas ${notification.icon} text-${notification.color}-600 dark:text-${notification.color}-400"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">${notification.title}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${notification.message}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">${this.formatTime(notification.time)}</p>
                                        </div>
                                        <div class="flex items-center space-x-1 ml-2">
                                            ${!notification.read ? '<div class="w-2 h-2 bg-blue-500 rounded-full"></div>' : ''}
                                            <button onclick="event.stopPropagation(); notificationManager.deleteNotification('${notification.id}')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-1">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');

                list.innerHTML = html;
            }

            formatTime(timeString) {
                const time = new Date(timeString);
                const now = new Date();
                const diff = now - time;
                const minutes = Math.floor(diff / 60000);
                const hours = Math.floor(diff / 3600000);
                const days = Math.floor(diff / 86400000);

                if (minutes < 1) return 'Just now';
                if (minutes < 60) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                if (hours < 24) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
                if (days < 7) return `${days} day${days > 1 ? 's' : ''} ago`;
                return time.toLocaleDateString();
            }

            saveToStorage() {
                localStorage.setItem('notifications', JSON.stringify(this.notifications));
            }
        }

        // Initialize notification manager
        let notificationManager;
        
        // Notification dropdown toggle
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notificationDropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Close notification dropdown
        function closeNotificationDropdown(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const toggle = document.getElementById('notificationToggle');
            
            if (dropdown && !dropdown.contains(event.target) && !toggle.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }

        // Global functions for notification actions
        function markAllAsRead() {
            if (notificationManager) {
                notificationManager.markAllAsRead();
            }
        }

        function viewAllNotifications() {
            // Navigate to notifications page
            console.log('Navigate to all notifications');
            // In real app, this would navigate to a notifications page
        }
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                const currentTheme = getSavedTheme();
                if (currentTheme === THEMES.system) {
                    applyTheme(THEMES.system);
                }
            });
        }

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

        // Theme toggle event listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize theme
            const savedTheme = getSavedTheme();
            applyTheme(savedTheme);
            
            // Theme toggle button
            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleThemeDropdown);
            }
            
            // Initialize notification manager
            notificationManager = new NotificationManager();
            
            // Notification toggle button
            const notificationToggle = document.getElementById('notificationToggle');
            if (notificationToggle) {
                notificationToggle.addEventListener('click', toggleNotificationDropdown);
            }
            
            // Close dropdowns on outside click
            document.addEventListener('click', (event) => {
                closeThemeDropdown(event);
                closeNotificationDropdown(event);
            });
        });

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
