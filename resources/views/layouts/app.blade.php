<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jadwal App</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <nav class="bg-blue-600 text-white p-4 mb-6">
        <div class="container mx-auto flex justify-between">
            <a href="{{ url('/') }}" class="font-bold">JadwalApp</a>
            <div>
                @auth
                    <span class="mr-4">Halo, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="underline">Logout</button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="underline mr-4">Login</a>
                    <a href="{{ route('register') }}" class="underline">Register</a>
                @endguest
            </div>
        </div>
    </nav>


    <div class="container mx-auto p-4">
        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @yield('content')
    </div>


    @yield('scripts')
</body>

</html>
