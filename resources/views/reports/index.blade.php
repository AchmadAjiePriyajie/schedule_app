@extends('layouts.app')

@section('content')
<div class="min-h-screen py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Laporan Jadwal & Surat</h1>
            </div>
            <p class="text-gray-600 ml-15">Kelola dan filter laporan kegiatan dengan mudah</p>
        </div>

        <!-- Filter Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 mb-6">
            <form method="GET" action="{{ route('reports.index') }}" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="start_date" class="block text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 inline mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Dari Tanggal
                        </label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 outline-none">
                    </div>
                    <div class="space-y-2">
                        <label for="end_date" class="block text-sm font-semibold text-gray-700">
                            <svg class="w-4 h-4 inline mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Sampai Tanggal
                        </label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                            class="w-full border-2 border-gray-200 rounded-xl px-4 py-3 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition-all duration-200 outline-none">
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-6 py-3 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Data
                    </button>
                    <a href="{{ route('reports.export', request()->only('start_date', 'end_date')) }}"
                        class="flex items-center gap-2 bg-white border-2 border-green-600 text-green-600 px-6 py-3 rounded-xl hover:bg-green-50 transform hover:scale-105 transition-all duration-200 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Excel
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                            <th class="px-6 py-4 text-left text-sm font-bold">No</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Nama Kegiatan</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Nomor Surat</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Lokasi</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Waktu Mulai</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Waktu Selesai</th>
                            <th class="px-6 py-4 text-left text-sm font-bold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($schedules as $item)
                            <tr class="hover:bg-emerald-50/50 transition-colors duration-150">
                                <td class="px-6 py-4 text-gray-700 font-medium">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-gray-800 font-semibold">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $item->nomor_surat }}</td>
                                <td class="px-6 py-4 text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $item->location }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <div class="text-sm">{{ \Carbon\Carbon::parse($item->start_time)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->start_time)->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <div class="text-sm">{{ \Carbon\Carbon::parse($item->end_time)->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($item->end_time)->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 1)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Disetujui
                                        </span>
                                    @elseif($item->status == 2)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Menunggu
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-gray-500 font-medium">Tidak ada data ditemukan</p>
                                        <p class="text-gray-400 text-sm">Coba ubah filter pencarian Anda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $schedules->links() }}
            </div>
        </div>
    </div>
</div>
@endsection