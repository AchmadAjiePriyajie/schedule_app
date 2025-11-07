@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    {{-- Header Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Surat Pengajuan</h1>
                <p class="text-sm text-gray-500 mt-1">Semua file yang diupload pada jadwal</p>
            </div>
            <div class="text-right">
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-4 inline-block">
                    <p class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">{{ $totalFiles }}</p>
                    <p class="text-xs text-gray-600 font-medium">Total File</p>
                </div>
            </div>
        </div>

        {{-- Filter & Search --}}
        <div class="flex flex-col md:flex-row gap-3">
            {{-- Search --}}
            <div class="flex-1">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari nama file, acara, atau user..."
                        class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Sort & Filter --}}
            <div class="flex gap-2">
                <select id="sortBy"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 text-sm font-medium text-gray-700 transition-all">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="name_asc">Nama A-Z</option>
                    <option value="name_desc">Nama Z-A</option>
                </select>

                <select id="filterType"
                    class="border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 text-sm font-medium text-gray-700 transition-all">
                    <option value="all">Semua Tipe</option>
                    <option value="image">Gambar</option>
                    <option value="document">Dokumen</option>
                    <option value="spreadsheet">Spreadsheet</option>
                    <option value="other">Lainnya</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Grid Gallery --}}
    <div id="galleryContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($schedules as $schedule)
            @if ($schedule->attachment)
                <div class="file-item group bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100"
                    data-name="{{ $schedule->name }}" data-user="{{ $schedule->user->name }}"
                    data-date="{{ $schedule->created_at->timestamp }}" data-filename="{{ basename($schedule->attachment) }}"
                    data-type="{{ $schedule->file_type ?? 'other' }}">

                    {{-- Preview Area --}}
                    <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 h-48 flex items-center justify-center overflow-hidden">
                        @php
                            $extension = strtolower(pathinfo($schedule->attachment, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                        @endphp

                        @if ($isImage)
                            {{-- Image Preview --}}
                            <img src="{{ Storage::url($schedule->attachment) }}" alt="{{ $schedule->name }}"
                                class="w-full h-full object-cover cursor-pointer group-hover:scale-110 transition-transform duration-500"
                                onclick="openPreviewModal('{{ Storage::url($schedule->attachment) }}', '{{ $schedule->name }}', 'image')">
                        @else
                            {{-- File Icon Based on Extension --}}
                            <div class="text-center cursor-pointer group-hover:scale-110 transition-transform duration-300"
                                onclick="openPreviewModal('{{ Storage::url($schedule->attachment) }}', '{{ $schedule->name }}', '{{ $extension }}')">
                                @if (in_array($extension, ['pdf']))
                                    <div class="bg-red-50 p-4 rounded-2xl inline-block">
                                        <svg class="w-16 h-16 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18.5,9H13V3.5L18.5,9M6,20V4H12V10H18V20H6Z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-700 mt-3">PDF Document</p>
                                @elseif(in_array($extension, ['doc', 'docx']))
                                    <div class="bg-blue-50 p-4 rounded-2xl inline-block">
                                        <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-700 mt-3">Word Document</p>
                                @elseif(in_array($extension, ['xls', 'xlsx']))
                                    <div class="bg-emerald-50 p-4 rounded-2xl inline-block">
                                        <svg class="w-16 h-16 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M12.9,14.5L15.8,19H14L12,15.6L10,19H8.2L11.1,14.5L8.2,10H10L12,13.4L14,10H15.8L12.9,14.5Z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-700 mt-3">Excel Spreadsheet</p>
                                @elseif(in_array($extension, ['zip', 'rar']))
                                    <div class="bg-amber-50 p-4 rounded-2xl inline-block">
                                        <svg class="w-16 h-16 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,17H12V15H14M14,13H12V11H14M10,9H12V7H10M10,13H12V11H10M10,17H12V15H10M14,9H12V7H14M20,19A2,2 0 0,1 18,21H6A2,2 0 0,1 4,19V7A2,2 0 0,1 6,5H10L12,7H18A2,2 0 0,1 20,9V19Z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-700 mt-3">Archive File</p>
                                @else
                                    <div class="bg-gray-50 p-4 rounded-2xl inline-block">
                                        <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                        </svg>
                                    </div>
                                    <p class="text-xs font-semibold text-gray-700 mt-3">{{ strtoupper($extension) }} File</p>
                                @endif
                            </div>
                        @endif

                        {{-- File Type Badge --}}
                        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-700 shadow-sm">
                            .{{ $extension }}
                        </span>
                    </div>

                    {{-- Info Area --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 truncate mb-1 group-hover:text-emerald-600 transition-colors" 
                            title="{{ $schedule->name }}">
                            {{ $schedule->name }}
                        </h3>
                        <p class="text-xs text-gray-500 truncate mb-3 flex items-center gap-1" 
                           title="{{ basename($schedule->attachment) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            {{ basename($schedule->attachment) }}
                        </p>

                        <div class="flex items-center justify-between text-xs text-gray-500 mb-4 pb-4 border-b border-gray-100">
                            <span class="flex items-center gap-1.5">
                                <div class="bg-emerald-100 p-1 rounded-full">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $schedule->user->name }}</span>
                            </span>
                            <span class="text-gray-400">{{ $schedule->created_at->diffForHumans() }}</span>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-2">
                            <a href="{{ Storage::url($schedule->attachment) }}" download
                                class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white text-center py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download
                            </a>
                            <button type="button"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-2.5 rounded-xl text-sm font-medium transition-all flex items-center justify-center gap-1.5"
                                onclick='openScheduleModal(@json($schedule))'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col-span-full text-center py-16">
                <div class="bg-gray-50 rounded-2xl p-12 inline-block">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada File</h3>
                    <p class="text-sm text-gray-500">Upload file melalui jadwal untuk melihatnya di sini</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- No Results Message --}}
    <div id="noResults" class="hidden text-center py-16">
        <div class="bg-gray-50 rounded-2xl p-12 inline-block">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak Ada Hasil</h3>
            <p class="text-sm text-gray-500">Coba kata kunci lain atau ubah filter</p>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $schedules->links() }}
    </div>
</div>

{{-- Modal Preview --}}
<div id="previewModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden justify-center items-center z-50 p-4"
    onclick="closePreviewModal()">
    <div class="relative max-w-5xl max-h-[90vh] w-full" onclick="event.stopPropagation()">
        <button onclick="closePreviewModal()"
            class="absolute -top-12 right-0 bg-white/10 hover:bg-white/20 text-white rounded-full p-2 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div id="previewContent" class="bg-white rounded-2xl overflow-hidden shadow-2xl max-h-[90vh] overflow-y-auto">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

{{-- Modal Jadwal --}}
<div id="scheduleModal"
    class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4 transition-all"
    onclick="closeScheduleModal()">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 relative">
            <button onclick="closeScheduleModal()" 
                class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 text-white rounded-full p-2 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 id="modalTitle" class="text-2xl font-bold text-white pr-10">Judul Jadwal</h2>
            <p id="modalDescription" class="text-emerald-50 mt-2 text-sm">Deskripsi kegiatan</p>
        </div>

        {{-- Modal Body --}}
        <div class="p-6 space-y-4">
            
            {{-- Location --}}
            <div class="flex items-start gap-3">
                <div class="bg-blue-50 p-2.5 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 mb-1">Lokasi</p>
                    <p id="modalLocation" class="text-sm text-gray-800 font-medium"></p>
                </div>
            </div>

            {{-- Time --}}
            <div class="flex items-start gap-3">
                <div class="bg-emerald-50 p-2.5 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 mb-1">Waktu</p>
                    <p id="modalTime" class="text-sm text-gray-800 font-medium"></p>
                </div>
            </div>

            {{-- User --}}
            <div class="flex items-start gap-3">
                <div class="bg-purple-50 p-2.5 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 mb-1">Dibuat oleh</p>
                    <p id="modalUser" class="text-sm text-gray-800 font-medium"></p>
                </div>
            </div>

            {{-- Nomor Surat --}}
            <div class="flex items-start gap-3">
                <div class="bg-amber-50 p-2.5 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 mb-1">Nomor Surat</p>
                    <p id="modalNomorSurat" class="text-sm text-gray-800 font-medium"></p>
                </div>
            </div>

            {{-- Status --}}
            <div class="flex items-start gap-3">
                <div class="bg-gray-50 p-2.5 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-medium text-gray-500 mb-1">Status</p>
                    <span id="modalStatus" class="inline-block px-3 py-1.5 rounded-lg text-xs font-semibold"></span>
                </div>
            </div>

            {{-- Attachment Section --}}
            <div class="pt-4 border-t border-gray-100">
                <p class="text-xs font-medium text-gray-500 mb-3">Lampiran</p>
                <div id="modalAttachment" class="bg-gray-50 rounded-xl p-4"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        let allItems = [];

        const statusClasses = {
            0: 'bg-amber-100 text-amber-700',
            1: 'bg-emerald-100 text-emerald-700',
            2: 'bg-blue-100 text-blue-700',
            3: 'bg-gray-100 text-gray-700',
            4: 'bg-red-100 text-red-700',
        };

        const statusLabels = {
            0: 'Pending',
            1: 'Accepted',
            2: 'On Going',
            3: 'Finished',
            4: 'Cancelled',
        };

        function openScheduleModal(schedule) {
            document.getElementById('modalTitle').innerText = schedule.name;
            document.getElementById('modalDescription').innerText = schedule.description ?? 'Tidak ada deskripsi';
            document.getElementById('modalLocation').innerText = schedule.location ?? 'Tidak ada lokasi';
            document.getElementById('modalUser').innerText = schedule.user?.name ?? 'Tidak diketahui';
            document.getElementById('modalNomorSurat').innerText = schedule.nomor_surat ?? '-';
            
            console.log(schedule);
            

            const start = new Date(schedule.start_time);
            const end = new Date(schedule.end_time);
            document.getElementById('modalTime').innerText =
                `${start.toLocaleString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                })} — ${end.toLocaleString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                })}`;

            // Status
            const statusEl = document.getElementById('modalStatus');
            statusEl.innerText = statusLabels[schedule.status] ?? 'Unknown';
            statusEl.className = `inline-block px-3 py-1.5 rounded-lg text-xs font-semibold ${statusClasses[schedule.status]}`;

            // Lampiran
            const modalAttachment = document.getElementById('modalAttachment');
            if (schedule.attachment) {
                const fileUrl = `{{ Storage::url('') }}/${schedule.attachment}`;
                const ext = schedule.attachment.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext)) {
                    modalAttachment.innerHTML = `
                        <img src="${fileUrl}" alt="Attachment" class="rounded-xl w-full shadow-sm">
                    `;
                } else if (ext === 'pdf') {
                    modalAttachment.innerHTML = `
                        <iframe src="${fileUrl}" class="w-full h-96 border-0 rounded-xl"></iframe>
                    `;
                } else {
                    modalAttachment.innerHTML = `
                        <div class="text-center py-6">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                            </svg>
                            <a href="${fileUrl}" target="_blank"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Buka File (${ext.toUpperCase()})
                            </a>
                        </div>
                    `;
                }
            } else {
                modalAttachment.innerHTML = `
                    <div class="text-center py-6">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-sm">Tidak ada lampiran</p>
                    </div>
                `;
            }

            document.getElementById('scheduleModal').classList.remove('hidden');
        }

        function closeScheduleModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Store all items
            allItems = Array.from(document.querySelectorAll('.file-item'));

            // Search functionality
            document.getElementById('searchInput').addEventListener('input', filterItems);

            // Sort functionality
            document.getElementById('sortBy').addEventListener('change', filterItems);

            // Filter type functionality
            document.getElementById('filterType').addEventListener('change', filterItems);
        });

        function filterItems() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const sortBy = document.getElementById('sortBy').value;
            const filterType = document.getElementById('filterType').value;

            let filteredItems = allItems.filter(item => {
                const name = item.dataset.name.toLowerCase();
                const user = item.dataset.user.toLowerCase();
                const filename = item.dataset.filename.toLowerCase();
                const itemType = item.dataset.type;

                // Search filter
                const matchesSearch = name.includes(searchTerm) ||
                    user.includes(searchTerm) ||
                    filename.includes(searchTerm);

                // Type filter
                const matchesType = filterType === 'all' || itemType === filterType;

                return matchesSearch && matchesType;
            });

            // Sort items
            filteredItems.sort((a, b) => {
                switch (sortBy) {
                    case 'newest':
                        return parseInt(b.dataset.date) - parseInt(a.dataset.date);
                    case 'oldest':
                        return parseInt(a.dataset.date) - parseInt(b.dataset.date);
                    case 'name_asc':
                        return a.dataset.name.localeCompare(b.dataset.name);
                    case 'name_desc':
                        return b.dataset.name.localeCompare(a.dataset.name);
                    default:
                        return 0;
                }
            });

            // Hide all items first
            allItems.forEach(item => item.style.display = 'none');

            // Show filtered and sorted items
            const container = document.getElementById('galleryContainer');
            filteredItems.forEach(item => {
                item.style.display = 'block';
                container.appendChild(item); // Re-append to maintain order
            });

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (filteredItems.length === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

        function openPreviewModal(url, name, type) {
            const modal = document.getElementById('previewModal');
            const content = document.getElementById('previewContent');

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            if (type === 'image') {
                content.innerHTML = `
                    <div class="max-h-[80vh] overflow-hidden">
                        <img src="${url}" alt="${name}" class="w-full h-full object-contain">
                    </div>
                    <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-3">${name}</h3>
                        <a href="${url}" download class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download File
                        </a>
                    </div>
                `;
            } else if (type === 'pdf') {
                content.innerHTML = `
                    <iframe src="${url}" class="w-full h-[70vh]"></iframe>
                    <div class="p-6 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-3">${name}</h3>
                        <a href="${url}" download class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download File
                        </a>
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div class="p-12 text-center">
                        <div class="bg-gray-100 p-6 rounded-2xl inline-block mb-4">
                            <svg class="w-20 h-20 text-gray-400 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">${name}</h3>
                        <p class="text-gray-600 mb-6">Preview tidak tersedia untuk tipe file ini</p>
                        <a href="${url}" download class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download File
                        </a>
                    </div>
                `;
            }
        }

        function closePreviewModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modals with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closePreviewModal();
                closeScheduleModal();
            }
        });
    </script>
@endpush