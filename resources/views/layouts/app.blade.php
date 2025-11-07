<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('styles')
    <style>
        @keyframes slideIn {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-slide-in { animation: slideIn 0.5s ease-out; }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .sidebar-gradient {
            background: linear-gradient(180deg, #059669 0%, #047857 50%, #065f46 100%);
        }
        
        .nav-link {
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: #10b981;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .nav-link:hover::before,
        .nav-link.active::before {
            transform: translateX(0);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(5, 150, 105, 0.1), 0 10px 10px -5px rgba(5, 150, 105, 0.04);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-emerald-50 via-teal-50 to-green-50 font-sans antialiased" x-data="{ sidebarOpen: true }">

    <div class="min-h-screen flex">

        <!-- Sidebar Modern -->
        <aside :class="sidebarOpen ? 'w-72' : 'w-20'"
            class="sidebar-gradient text-white shadow-2xl p-6 transition-all duration-300 flex flex-col relative animate-slide-in">

            <!-- Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="absolute -right-4 top-8 bg-gradient-to-r from-emerald-400 to-teal-500 text-white rounded-full p-2 shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" :class="sidebarOpen ? 'rotate-0' : 'rotate-180'" 
                    class="h-5 w-5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>

            <!-- Logo Section -->
            <div class="flex items-center gap-3 mb-12 pb-6 border-b border-emerald-400/30">
                <div class="bg-gradient-to-br from-emerald-400 to-teal-500 p-3 rounded-xl shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div x-show="sidebarOpen" x-transition class="flex flex-col">
                    <h1 class="text-2xl font-bold tracking-tight">Jadwal</h1>
                    <p class="text-xs text-emerald-200">Management System</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2 flex-1">
                <a href="{{ route('dashboard') }}"
                    class="nav-link flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/20 group {{ request()->routeIs('dashboard') ? 'bg-white/20 active' : '' }}">
                    <div class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Home</span>
                </a>

                <a href="{{ route('schedules.index') }}"
                    class="nav-link flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/20 group {{ request()->routeIs('schedules.index') ? 'bg-white/20 active' : '' }}">
                    <div class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Agenda</span>
                </a>

                @if (auth()->user()->is_admin)
                <a href="{{ route('schedules.waiting') }}"
                    class="nav-link flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/20 group {{ request()->routeIs('schedules.waiting') ? 'bg-white/20 active' : '' }}">
                    <div class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Antrian</span>
                </a>
                @endif

                <a href="{{ route('schedules.attachments') }}"
                    class="nav-link flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/20 group {{ request()->routeIs('schedules.attachments') ? 'bg-white/20 active' : '' }}">
                    <div class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Arsip</span>
                </a>

                @if (auth()->user()->is_admin)
                <a href="{{ route('reports.index') }}"
                    class="nav-link flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/20 group {{ request()->routeIs('reports.index') ? 'bg-white/20 active' : '' }}">
                    <div class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Rekap</span>
                </a>

                <a href="{{ route('users.create') }}"
                    class="nav-link flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-300 hover:bg-white/20 group {{ request()->routeIs('schedules.create') ? 'bg-white/20 active' : '' }}">
                    <div class="bg-white/10 p-2 rounded-lg group-hover:bg-white/20 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <span x-show="sidebarOpen" x-transition class="font-medium">Tambah User</span>
                </a>
                @endif
            </nav>

            <!-- Footer Info -->
            <div x-show="sidebarOpen" x-transition class="mt-6 pt-6 border-t border-emerald-400/30">
                <p class="text-xs text-emerald-200 text-center">© 2025 Jadwal System</p>
            </div>

        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">

            <!-- Modern Navbar -->
            <header class="glass-effect shadow-sm px-8 py-4 flex items-center justify-between border-b border-emerald-100 animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-1 bg-gradient-to-b from-emerald-500 to-teal-600 rounded-full"></div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">@yield('title', 'Dashboard')</h2>
                        <p class="text-xs text-gray-500">{{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Notification Bell -->
                    <button class="relative p-2 hover:bg-emerald-50 rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                            class="flex items-center gap-3 px-4 py-2 hover:bg-emerald-50 rounded-xl transition-all duration-300 focus:outline-none group">
                            <div class="bg-gradient-to-br from-emerald-400 to-teal-500 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->is_admin ? 'Administrator' : 'User' }}</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                :class="open ? 'rotate-180' : 'rotate-0'"
                                class="w-4 h-4 text-gray-500 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                            @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-3 w-52 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden">
                            
                            <div class="p-3 bg-gradient-to-r from-emerald-50 to-teal-50 border-b border-gray-200">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-emerald-50 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-sm font-medium">Profil Saya</span>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}" class="block border-t border-gray-100">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="text-sm font-medium">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-8 overflow-y-auto">
                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')
    @stack('scripts')
</body>

</html>