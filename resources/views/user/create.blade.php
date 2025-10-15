{{-- resources/views/users/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Buat User Baru</h2>

    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-500 text-white">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
        </div>

        <div class="flex items-center gap-3">
            {{-- hidden default 0 supaya selalu dikirim --}}
            <input type="hidden" name="is_admin" value="0">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                       class="form-checkbox h-4 w-4 text-blue-600">
                <span class="ml-2 text-sm">Jadikan Admin</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Simpan User
            </button>
            <a href="{{ url()->previous() }}" class="ml-3 text-sm text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection
