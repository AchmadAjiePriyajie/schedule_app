<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true }">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" 
               class="bg-white shadow-md p-5 transition-all duration-300 flex flex-col">
            <!-- Tombol toggle -->
            <button @click="sidebarOpen = !sidebarOpen" 
                class="mb-6 text-gray-700 hover:text-blue-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Logo -->
            <h1 x-show="sidebarOpen" class="text-xl font-bold mb-6">MyApp</h1>

            <!-- Menu -->
            <nav class="space-y-2 flex-1">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('dashboard') ? 'bg-gray-200' : '' }}">
                   <span>🏠</span>
                   <span x-show="sidebarOpen">Dashboard</span>
                </a>
                <a href="{{ route('schedules.index') }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('schedules.*') ? 'bg-gray-200' : '' }}">
                   <span>📅</span>
                   <span x-show="sidebarOpen">Schedules</span>
                </a>
            </nav>
        </aside>

        <!-- Konten -->
        <div class="flex-1">
            <!-- Navbar -->
            @includeIf('layouts.navigation')

            <!-- Konten Halaman -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
