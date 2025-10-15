<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('styles')
</head>

<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: true }">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'"
            class="bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-lg p-5 transition-all duration-300 flex flex-col relative">

            <!-- Tombol toggle -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="absolute -right-3 top-6 bg-white text-blue-700 rounded-full p-1 shadow hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <div class="flex items-center gap-2 mb-10">
                <span class="text-3xl"></span>
                <h1 x-show="sidebarOpen" class="text-xl font-extrabold tracking-wide">Jadwal</h1>
            </div>

            <!-- Menu -->
            <nav class="space-y-2 flex-1">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-500/30 {{ request()->routeIs('dashboard') ? 'bg-blue-500/40' : '' }}">
                    <span></span>
                    <span x-show="sidebarOpen" class="font-medium">Home</span>
                </a>
                <a href="{{ route('schedules.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-500/30 {{ request()->routeIs('schedules.index') ? 'bg-blue-500/40' : '' }}">
                    <span></span>
                    <span x-show="sidebarOpen" class="font-medium">Agenda</span>
                </a>
                @if (auth()->user()->is_admin)
                    <a href="{{ route('schedules.waiting') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-500/30 {{ request()->routeIs('schedules.waiting') ? 'bg-blue-500/40' : '' }}">
                        <span></span>
                        <span x-show="sidebarOpen" class="font-medium">Antrian</span>
                    </a>
                @endif
                <a href="{{ route('schedules.attachments') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-500/30 {{ request()->routeIs('schedules.attachments') ? 'bg-blue-500/40' : '' }}">
                    <span></span>
                    <span x-show="sidebarOpen" class="font-medium">Arsip</span>
                </a>
                @if (auth()->user()->is_admin)
                    <a href="{{ route('reports.index') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-500/30 {{ request()->routeIs('reports.index') ? 'bg-blue-500/40' : '' }}">
                        <span></span>
                        <span x-show="sidebarOpen" class="font-medium">Laporan</span>
                    </a>
                @endif
                @if (auth()->user()->is_admin)
                    <a href="{{ route('users.create') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-blue-500/30 {{ request()->routeIs('schedules.create') ? 'bg-blue-500/40' : '' }}">
                        <span></span>
                        <span x-show="sidebarOpen" class="font-medium">Tambah User</span>
                    </a>
                @endif
            </nav>

            <!-- Footer sidebar -->
            <div class="mt-6 border-t border-white/20 pt-4">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition hover:bg-red-600/30">
                    <span></span>
                    <span x-show="sidebarOpen" class="font-medium">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </aside>

        <!-- Konten -->
        <div class="flex-1 flex flex-col">

            <!-- Navbar -->
            <header class="bg-white shadow-sm px-6 py-3 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <!-- Search -->
                    <div class="hidden md:block">
                        <input type="text" placeholder="Search..."
                            class="px-3 py-2 border rounded-lg focus:ring focus:ring-blue-200 text-sm">
                    </div>
                    <!-- Profile -->
                    <div class="flex items-center gap-2">
                        <img src="https://i.pravatar.cc/40" class="w-8 h-8 rounded-full border" alt="profile">
                        <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Konten Halaman -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
    @stack('scripts')
</body>

</html>