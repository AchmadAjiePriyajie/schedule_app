@extends('layouts.app')

@section('content')

{{-- Header Section --}}
<div class="mb-6">
    <div class="flex items-center gap-3 mb-2">
        <div
            class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Manajemen Jadwal</h2>
            <p class="text-sm text-gray-500">Kelola jadwal acara Anda dengan mudah</p>
        </div>
    </div>
</div>

{{-- Filter Card --}}
<div class="bg-white shadow-sm rounded-2xl p-6 mb-6 border border-gray-100">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
        </svg>
        <h3 class="text-lg font-semibold text-gray-800">Filter & Pencarian</h3>
    </div>

    <form method="GET" action="{{ route('schedules.waiting') }}"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Filter Tanggal --}}
        <div>
            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
        </div>

        <div>
            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
        </div>

        {{-- Filter Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select name="status" id="status"
                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                <option value="">Semua Status</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Accepted</option>
                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>On Going</option>
                <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Finished</option>
                <option value="4" {{ request('status') == '4' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        {{-- Sort --}}
        <div>
            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
            <select name="sort" id="sort"
                class="w-full border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A–Z)</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z–A)</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex items-end gap-2">
            <button type="submit"
                class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-500/30 font-medium transition-all hover:shadow-xl">
                <span class="flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </span>
            </button>
            <a href="{{ route('schedules.waiting') }}"
                class="px-4 py-2.5 border-2 border-gray-200 hover:border-gray-300 text-gray-700 rounded-xl font-medium transition-all hover:bg-gray-50">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Table Card --}}
<div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-emerald-50 to-teal-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nomor
                        Permohonan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama
                        Acara</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal
                        & Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Lokasi
                    </th>
                    @if (auth()->user()->is_admin)
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User
                        </th>
                    @endif
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Surat
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($schedules as $schedule)
                                <tr class="hover:bg-emerald-50/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $schedule->nomor_surat }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $schedule->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="flex items-center gap-2 mb-1">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y H:i') }}
                                            </div>
                                            <div class="flex items-center gap-2 text-gray-600">
                                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('d M Y H:i') }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ $schedule->location ?? '-' }}</span>
                                        </div>
                                    </td>
                                    @if (auth()->user()->is_admin)
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                                    {{ substr($schedule->user->name, 0, 1) }}
                                                </div>
                                                <span class="text-sm text-gray-900">{{ $schedule->user->name }}</span>
                                            </div>
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                0 => ['label' => 'Pending', 'class' => 'bg-amber-100 text-amber-700 border-amber-200'],
                                                1 => ['label' => 'Accepted', 'class' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                                                2 => ['label' => 'On Going', 'class' => 'bg-blue-100 text-blue-700 border-blue-200'],
                                                3 => ['label' => 'Finished', 'class' => 'bg-gray-100 text-gray-700 border-gray-200'],
                                                4 => ['label' => 'Cancelled', 'class' => 'bg-rose-100 text-rose-700 border-rose-200'],
                                            ];
                                            $currentStatus = $statusConfig[$schedule->status] ?? $statusConfig[0];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $currentStatus['class'] }}">
                                            {{ $currentStatus['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($schedule->attachment)
                                                            @php
                                                                $extension = pathinfo($schedule->attachment, PATHINFO_EXTENSION);
                                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                                $isPdf = strtolower($extension) === 'pdf';
                                                            @endphp

                                                            @if ($isImage)
                                                                <button
                                                                    onclick='showAttachment("{{ asset('storage/' . $schedule->attachment) }}", "image", "{{ $schedule->name }}")'
                                                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-2 rounded-lg text-xs font-medium shadow-sm transition-all">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                    </svg>
                                                                    Lihat
                                                                </button>
                                                            @elseif ($isPdf)
                                                                <a href="{{ asset('storage/' . $schedule->attachment) }}" target="_blank"
                                                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white px-3 py-2 rounded-lg text-xs font-medium shadow-sm transition-all">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                                    </svg>
                                                                    PDF
                                                                </a>
                                                            @else
                                                                <a href="{{ asset('storage/' . $schedule->attachment) }}" download
                                                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white px-3 py-2 rounded-lg text-xs font-medium shadow-sm transition-all">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                    </svg>
                                                                    Download
                                                                </a>
                                                            @endif
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-2 justify-center">
                                            <button onclick='openStatusModal(@json($schedule))'
                                                class="inline-flex items-center gap-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 px-3 py-1.5 rounded-lg text-white shadow-sm text-xs font-medium transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Status
                                            </button>
                                            <button onclick='openEditModal(@json($schedule))'
                                                class="inline-flex items-center gap-1 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 px-3 py-1.5 rounded-lg text-white shadow-sm text-xs font-medium transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                                                onsubmit="return confirm('Hapus jadwal ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center gap-1 bg-gradient-to-r from-rose-500 to-rose-600 hover:from-rose-600 hover:to-rose-700 text-white px-3 py-1.5 rounded-lg shadow-sm text-xs font-medium transition-all">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-6">
    {{ $schedules->links() }}
</div>

{{-- Modal Preview Attachment --}}
<div id="attachmentModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm hidden justify-center items-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-auto m-4">
        <div
            class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-2xl">
            <h3 id="attachmentTitle" class="text-lg font-bold text-gray-800"></h3>
            <button onclick="closeAttachmentModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="attachmentContent" class="p-6 flex justify-center">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

{{-- Modal Status --}}
<div id="statusModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Ubah Status Jadwal</h2>
        <form id="statusForm" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-gray-600 mb-1">Nama Acara</label>
                <p id="statusScheduleName" class="font-semibold text-gray-800"></p>
            </div>

            <div>
                <label class="block text-gray-600 mb-2">Pilih Status</label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="status" value="0" class="mr-3">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pending</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="status" value="1" class="mr-3">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Accepted</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="status" value="2" class="mr-3">
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">On
                            Going</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="status" value="3" class="mr-3">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">Finished</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="status" value="4" class="mr-3">
                        <span
                            class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">Cancelled</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-2 pt-4">
                <button type="button" onclick="closeStatusModal()"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</button>
                <button type="submit"
                    class="flex-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-2.5 rounded-xl shadow-lg shadow-emerald-500/30 font-medium transition-all hover:shadow-xl">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Jadwal --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-lg font-bold mb-4">Edit Jadwal</h2>
        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama acara --}}
            <div>
                <label class="block text-gray-600 mb-1">Nama Acara</label>
                <input type="text" name="name" id="editName"
                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    required>
            </div>

            {{-- Start Time --}}
            <div>
                <label class="block text-gray-600 mb-1">Waktu Mulai</label>
                <input type="datetime-local" name="start_time" id="editStart"
                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    required>
            </div>

            {{-- End Time --}}
            <div>
                <label class="block text-gray-600 mb-1">Waktu Selesai</label>
                <input type="datetime-local" name="end_time" id="editEnd"
                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    required>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-gray-600 mb-1">Deskripsi Acara</label>
                <textarea name="description" id="editDescription" rows="3"
                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"></textarea>
            </div>

            {{-- Attachment --}}
            <div>
                <label class="block text-gray-600 mb-1">Attachment (Opsional)</label>
                <input type="file" name="attachment" id="editAttachment" accept="image/*,.pdf,.doc,.docx"
                    class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF, DOC, DOCX (Max: 5MB)</p>
                <div id="currentAttachment" class="mt-2"></div>
            </div>

            {{-- Lokasi (search + map picker) --}}
            <div class="relative">
                <label class="block text-gray-600 mb-1">Lokasi</label>
                <input type="text" id="editLocationSearch"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    placeholder="Cari nama tempat...">

                <ul id="editSearchResults"
                    class="absolute bg-white border border-gray-200 rounded-lg mt-1 shadow-lg hidden max-h-60 overflow-y-auto z-50 w-full">
                </ul>
            </div>

            {{-- Peta --}}
            <div class="mb-3">
                <label class="block text-gray-600 mb-1">Pilih Lokasi dari Peta</label>
                <div id="editMap" style="height: 300px; border: 1px solid #ccc; border-radius: 8px;"></div>
            </div>

            {{-- Hidden fields for geolocation --}}
            <input type="hidden" name="location" id="editLocation">
            <input type="hidden" name="latitude" id="editLatitude">
            <input type="hidden" name="longitude" id="editLongitude">

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100">Batal</button>
                <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection


{{-- Tambahkan Leaflet CSS & JS --}}
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        .leaflet-default-icon-path {
            background-image: url(https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        let editMap, editMarker;
        let mapInitialized = false;

        // ==== Fungsi Attachment Preview ====
        function showAttachment(url, type, title) {
            const modal = document.getElementById('attachmentModal');
            const content = document.getElementById('attachmentContent');
            const titleEl = document.getElementById('attachmentTitle');

            titleEl.textContent = title;

            if (type === 'image') {
                content.innerHTML = `<img src="${url}" class="max-w-full h-auto rounded-lg" alt="${title}">`;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAttachmentModal() {
            const modal = document.getElementById('attachmentModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ==== Fungsi Status Modal ====
        function openStatusModal(schedule) {
            document.getElementById('statusScheduleName').textContent = schedule.name;
            document.getElementById('statusForm').action = `/schedules/${schedule.id}/status`;



            const radioButtons = document.querySelectorAll('input[name="status"]');
            radioButtons.forEach(radio => {
                if (parseInt(radio.value) === schedule.status) {
                    radio.checked = true;
                }
            });

            const modal = document.getElementById('statusModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeStatusModal() {
            const modal = document.getElementById('statusModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // ==== Fungsi Edit Modal ====
        function openEditModal(jadwal) {
            console.log('Opening modal with schedule:', jadwal);

            document.getElementById('editName').value = jadwal.name || '';

            let startTime = jadwal.start_time || '';
            let endTime = jadwal.end_time || '';
            if (startTime) {
                startTime = startTime.substring(0, 16).replace(' ', 'T');
            }
            if (endTime) {
                endTime = endTime.substring(0, 16).replace(' ', 'T');
            }
            document.getElementById('editStart').value = startTime;
            document.getElementById('editEnd').value = endTime;

            document.getElementById('editDescription').value = jadwal.description || '';
            document.getElementById('editLocation').value = jadwal.location || '';
            document.getElementById('editLocationSearch').value = jadwal.location || '';
            document.getElementById('editLatitude').value = jadwal.latitude || '';
            document.getElementById('editLongitude').value = jadwal.longitude || '';

            // Show current attachment
            const currentAttachmentDiv = document.getElementById('currentAttachment');
            if (jadwal.attachment) {
                currentAttachmentDiv.innerHTML = `
                                        <div class="text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                            <span class="font-medium">File saat ini: </span>
                                            <a href="/storage/${jadwal.attachment}" target="_blank" class="text-blue-500 hover:underline">
                                                ${jadwal.attachment.split('/').pop()}
                                            </a>
                                        </div>
                                    `;
            } else {
                currentAttachmentDiv.innerHTML = '';
            }

            document.getElementById('editForm').action = `/schedules/${jadwal.id}`;

            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            let lat = parseFloat(jadwal.latitude) || -6.200000;
            let lng = parseFloat(jadwal.longitude) || 106.816666;

            setTimeout(() => {
                if (!mapInitialized) {
                    editMap = L.map('editMap').setView([lat, lng], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(editMap);

                    editMarker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(editMap);

                    editMarker.on('dragend', function (e) {
                        let pos = e.target.getLatLng();
                        updateEditLocation(pos.lat, pos.lng, 'Lokasi dipilih dari map');
                    });

                    editMap.on('click', function (e) {
                        let lat = e.latlng.lat;
                        let lng = e.latlng.lng;
                        editMarker.setLatLng([lat, lng]);
                        updateEditLocation(lat, lng, 'Lokasi dipilih dari map');
                    });

                    mapInitialized = true;
                } else {
                    editMap.setView([lat, lng], 13);
                    editMarker.setLatLng([lat, lng]);
                    setTimeout(() => {
                        editMap.invalidateSize();
                    }, 50);
                }
            }, 200);
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function updateEditLocation(lat, lng, name = '') {
            document.getElementById('editLatitude').value = lat;
            document.getElementById('editLongitude').value = lng;
            if (name) {
                document.getElementById('editLocation').value = name;
            }
        }

        // ==== Search Lokasi di Edit Modal ====
        document.getElementById('editLocationSearch').addEventListener('input', async function () {
            let query = this.value;
            let resultsList = document.getElementById('editSearchResults');

            if (query.length < 3) {
                resultsList.classList.add('hidden');
                return;
            }

            try {
                let url =
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&addressdetails=1&limit=5`;
                let response = await fetch(url);
                let data = await response.json();

                resultsList.innerHTML = '';

                if (data.length === 0) {
                    let li = document.createElement('li');
                    li.textContent = 'Tidak ada hasil ditemukan';
                    li.classList.add('p-2', 'text-gray-500', 'italic');
                    resultsList.appendChild(li);
                } else {
                    data.forEach(place => {
                        let li = document.createElement('li');
                        li.textContent = place.display_name;
                        li.classList.add('p-2', 'hover:bg-gray-100', 'cursor-pointer', 'border-b',
                            'last:border-b-0');
                        li.addEventListener('click', () => {
                            document.getElementById('editLocationSearch').value = place
                                .display_name;
                            document.getElementById('editLocation').value = place.display_name;
                            document.getElementById('editLatitude').value = place.lat;
                            document.getElementById('editLongitude').value = place.lon;

                            if (editMap) {
                                editMap.setView([place.lat, place.lon], 15);
                                editMarker.setLatLng([place.lat, place.lon]);
                            }

                            resultsList.innerHTML = '';
                            resultsList.classList.add('hidden');
                        });
                        resultsList.appendChild(li);
                    });
                }

                resultsList.classList.remove('hidden');
            } catch (error) {
                console.error('Error searching location:', error);
            }
        });

        document.addEventListener('click', function (e) {
            const searchInput = document.getElementById('editLocationSearch');
            const resultsList = document.getElementById('editSearchResults');

            if (e.target !== searchInput && !resultsList.contains(e.target)) {
                resultsList.classList.add('hidden');
            }
        });
    </script>
@endpush