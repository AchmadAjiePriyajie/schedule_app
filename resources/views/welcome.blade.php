<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Jadwal & Surat - Diskominfo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-emerald-500 to-teal-600 min-h-screen">

    <!-- Header -->
    <header class="bg-white/10 backdrop-blur-sm border-b border-white/20">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-xl">Sistem Manajemen</h1>
                        <p class="text-white/80 text-sm">Dinas Komunikasi dan Informatika</p>
                    </div>
                </div>
                <a href="/login"
                    class="bg-white text-emerald-600 px-6 py-2.5 rounded-xl font-semibold hover:shadow-lg transition-all duration-200">
                    Login
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-16">

        <!-- Welcome Section -->
        <div class="text-center mb-16 fade-in">
            <div class="inline-block px-5 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                <span class="text-white text-sm font-semibold">🏛️ Portal Internal Diskominfo</span>
            </div>
            <h2 class="text-5xl font-bold text-white mb-6">
                Selamat Datang di<br />
                Sistem Manajemen Jadwal & Surat
            </h2>
            <p class="text-xl text-white/90 max-w-2xl mx-auto mb-10">
                Platform terintegrasi untuk mengelola jadwal kegiatan, surat menyurat, dan laporan internal Diskominfo
            </p>
            <a href="/login"
                class="inline-flex items-center gap-2 bg-white text-emerald-600 px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-200">
                Masuk ke Sistem
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                    </path>
                </svg>
            </a>
        </div>

        <!-- Feature Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 hover:shadow-2xl transition-all duration-300">
                <div
                    class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Jadwal Kegiatan</h3>
                <p class="text-gray-600">Kelola dan monitoring jadwal kegiatan dinas secara terpusat dan terorganisir
                </p>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 hover:shadow-2xl transition-all duration-300">
                <div
                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Surat Menyurat</h3>
                <p class="text-gray-600">Arsip digital surat masuk dan keluar dengan sistem penomoran otomatis</p>
            </div>

            <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 hover:shadow-2xl transition-all duration-300">
                <div
                    class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Laporan</h3>
                <p class="text-gray-600">Generate laporan lengkap dan ekspor ke format Excel untuk dokumentasi</p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 md:p-12">
            <div class="flex items-start gap-6">
                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Informasi Akses</h3>
                    <p class="text-gray-600 mb-4">Sistem ini hanya dapat diakses oleh pegawai Dinas Komunikasi dan
                        Informatika yang memiliki akun aktif. Silakan hubungi Administrator untuk pembuatan akun atau
                        reset password.</p>
                    <div class="flex flex-wrap gap-4 mt-6">
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">admin@diskominfo.go.id</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium">Ext. 1234</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="py-8 px-6 bg-white/10 backdrop-blur-sm border-t border-white/20 mt-12">
        <div class="max-w-6xl mx-auto text-center">
            <p class="text-white/90 text-sm">© 2025 Dinas Komunikasi dan Informatika. Sistem Internal.</p>
        </div>
    </footer>

</body>

</html>