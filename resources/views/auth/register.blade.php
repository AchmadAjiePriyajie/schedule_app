<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Aplikasi</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-green-100 via-white to-green-200 min-h-screen flex items-center justify-center">

    <div
        class="w-full max-w-md bg-white shadow-2xl rounded-2xl p-8 transform transition duration-300 hover:scale-[1.02]">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800">Buat Akun 🚀</h1>
            <p class="text-gray-500">Daftar untuk mulai menggunakan aplikasi</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700">Nama</label>
                <input type="text" name="name" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition duration-200" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition duration-200" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition duration-200" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition duration-200" />
            </div>

            <button type="submit"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg shadow-md transition duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                Register
            </button>
        </form>

        <!-- Footer -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-green-500 font-medium hover:underline">Login di sini</a>
        </p>
    </div>

</body>

</html>
