{{-- resources/views/components/app-layout.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
    {{-- Sidebar --}}
    <aside class="w-64 bg-white dark:bg-gray-800 p-5">
      <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">MyApp</h2>
      <nav class="mt-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded {{ request()->routeIs('dashboard') ? 'bg-gray-200 dark:bg-gray-700' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">Dashboard</a>
        <a href="{{ route('schedules.index') }}" class="block px-3 py-2 rounded {{ request()->routeIs('schedules.*') ? 'bg-gray-200 dark:bg-gray-700' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">Schedules</a>
      </nav>
    </aside>

    {{-- Main --}}
    <div class="flex-1">
      @includeIf('layouts.navigation') {{-- optional: navbar --}}
      <main class="p-6">
        {{ $slot }}
      </main>
    </div>
  </div>
</body>
</html>
