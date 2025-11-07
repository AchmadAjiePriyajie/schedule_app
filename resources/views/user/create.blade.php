{{-- resources/views/users/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 py-8 px-4">
    <div class="max-w-2xl mx-auto">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ url()->previous() }}" 
                   class="flex items-center justify-center w-10 h-10 rounded-xl bg-white hover:bg-emerald-50 border border-gray-200 transition-all duration-200 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 group-hover:text-emerald-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                        Buat User Baru
                    </h1>
                    <p class="text-gray-600 text-sm mt-1">Tambahkan pengguna baru ke sistem</p>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 flex items-start gap-3 animate-fade-in">
            <div class="bg-emerald-500 rounded-full p-1 mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Error Alert -->
        @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 animate-fade-in">
            <div class="flex items-start gap-3">
                <div class="bg-red-500 rounded-full p-1 mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-red-800 font-medium mb-2">Terdapat beberapa kesalahan:</p>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $err)
                            <li class="text-red-700 text-sm flex items-start gap-2">
                                <span class="text-red-500 mt-1">•</span>
                                <span>{{ $err }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Main Form Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl border border-white/20 overflow-hidden">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Informasi User</h2>
                        <p class="text-emerald-100 text-sm">Lengkapi data pengguna dengan benar</p>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <!-- Name Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Nama Lengkap
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition duration-200 bg-gray-50 hover:bg-white"
                               placeholder="Contoh: John Doe" />
                    </div>
                </div>

                <!-- Email Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Email
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition duration-200 bg-gray-50 hover:bg-white"
                               placeholder="nama@email.com" />
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Password
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" required
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition duration-200 bg-gray-50 hover:bg-white"
                               placeholder="Minimal 8 karakter" />
                    </div>
                    <p class="text-xs text-gray-500 mt-1 ml-1">Password harus minimal 8 karakter</p>
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Konfirmasi Password
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="password" name="password_confirmation" required
                               class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition duration-200 bg-gray-50 hover:bg-white"
                               placeholder="Ulangi password" />
                    </div>
                </div>

                <!-- Admin Checkbox -->
                <div class="pt-4 pb-2">
                    <input type="hidden" name="is_admin" value="0">
                    <label class="flex items-center gap-3 p-4 rounded-2xl border-2 border-gray-200 hover:border-emerald-300 hover:bg-emerald-50/50 cursor-pointer transition-all duration-200 group">
                        <div class="relative">
                            <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                                   class="peer w-5 h-5 text-emerald-600 border-2 border-gray-300 rounded focus:ring-2 focus:ring-emerald-400 cursor-pointer" />
                            <svg class="absolute top-0 left-0 w-5 h-5 text-white pointer-events-none opacity-0 peer-checked:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <span class="text-sm font-semibold text-gray-700 group-hover:text-emerald-700 transition-colors">Jadikan sebagai Administrator</span>
                            <p class="text-xs text-gray-500 mt-0.5">Admin memiliki akses penuh ke seluruh sistem</p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-100 to-teal-100 p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-b from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 rounded-full shadow-lg transition duration-200 transform hover:-translate-y-0.5 hover:shadow-xl flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan User
                    </button>
                    <a href="{{ url()->previous() }}" 
                       class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-full hover:bg-gray-50 hover:border-gray-400 transition duration-200 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-4 flex items-start gap-3">
            <div class="bg-blue-500 rounded-full p-2 mt-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-blue-900">Informasi</p>
                <p class="text-xs text-blue-700 mt-1">User yang dibuat akan langsung dapat login menggunakan email dan password yang telah ditentukan.</p>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>
@endsection