<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi</title>
    @vite('resources/css/app.css')
</head>

<body
    class="bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-100 min-h-screen flex items-center justify-center p-4">

    <!-- Decorative Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute top-20 left-10 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-40 right-10 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-20 w-72 h-72 bg-cyan-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="w-full max-w-md relative">
        <!-- Main Card -->
        <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl p-8 border border-white/20">

            <!-- Logo/Icon with Gradient Background -->
            <div class="flex justify-center mb-6">
                <div class="bg-gradient-to-b from-emerald-500 to-teal-600 rounded-full p-4 shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
            </div>

            <!-- Header -->
            <div class="text-center mb-8">
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-2">
                    Selamat Datang 👋
                </h1>
                <p class="text-gray-600">Silakan login untuk melanjutkan</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                </path>
                            </svg>
                        </div>
                        <input type="email" name="email" required
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition duration-200 bg-gray-50 hover:bg-white"
                            placeholder="nama@email.com" />
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <input type="password" name="password" required
                            class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-2xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition duration-200 bg-gray-50 hover:bg-white"
                            placeholder="••••••••" />
                    </div>
                </div>

                <!-- Remember & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox"
                            class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                        <span class="ml-2 text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-emerald-600 hover:text-emerald-700 font-medium hover:underline">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-b from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 rounded-full shadow-lg transition duration-200 transform hover:-translate-y-0.5 hover:shadow-xl">
                    Login
                </button>
            </form>



            <!-- Footer -->
            <p class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}"
                    class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline">
                    Daftar sekarang
                </a>
            </p>
        </div>

        <!-- Additional Info -->
        <p class="text-center text-xs text-gray-500 mt-6">
            Dengan login, Anda menyetujui <a href="#" class="underline hover:text-emerald-600">Syarat & Ketentuan</a>
            kami
        </p>
    </div>

    <style>
        @keyframes blob {

            0%,
            100% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>

</body>

</html>