@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-700">Profil Saya</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Update Profil --}}
    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4 mb-8">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full border-gray-300 rounded-lg focus:ring-blue-200 focus:border-blue-400">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full border-gray-300 rounded-lg focus:ring-blue-200 focus:border-blue-400">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Simpan Perubahan
        </button>
    </form>

    {{-- Form Ganti Password --}}
    <h2 class="text-lg font-semibold mb-3 text-gray-700 border-t pt-4">Ganti Password</h2>

    <form action="{{ route('profile.updatePassword') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Password Lama</label>
            <input type="password" name="current_password"
                class="w-full border-gray-300 rounded-lg focus:ring-blue-200 focus:border-blue-400">
            @error('current_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password Baru</label>
            <input type="password" name="new_password"
                class="w-full border-gray-300 rounded-lg focus:ring-blue-200 focus:border-blue-400">
            @error('new_password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation"
                class="w-full border-gray-300 rounded-lg focus:ring-blue-200 focus:border-blue-400">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            Ubah Password
        </button>
    </form>
</div>
@endsection