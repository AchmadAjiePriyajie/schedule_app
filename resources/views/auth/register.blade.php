@extends('layouts.app')


@section('content')
    <h2 class="text-2xl font-bold mb-4">Register</h2>
    <form method="POST" action="{{ route('register') }}" class="bg-white p-4 rounded shadow max-w-md mx-auto">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>
        <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Register</button>
    </form>
@endsection
