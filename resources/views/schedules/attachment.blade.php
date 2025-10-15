@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        {{-- Header --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Surat Pengajuan</h1>
                    <p class="text-gray-600 text-sm mt-1">Semua file yang diupload pada jadwal</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-blue-600">{{ $totalFiles }}</p>
                    <p class="text-xs text-gray-500">Total File</p>
                </div>
            </div>

            {{-- Filter & Search --}}
            <div class="flex flex-col md:flex-row gap-4 mt-6">
                {{-- Search --}}
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari nama file, acara, atau user..."
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Sort --}}
                <div class="flex gap-2">
                    <select id="sortBy"
                        class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="name_asc">Nama A-Z</option>
                        <option value="name_desc">Nama Z-A</option>
                    </select>

                    {{-- Filter Type --}}
                    <select id="filterType"
                        class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
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
        <div id="galleryContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse ($schedules as $schedule)
                @if ($schedule->attachment)
                    <div class="file-item bg-white rounded-xl shadow-md hover:shadow-xl transition duration-300 overflow-hidden"
                        data-name="{{ $schedule->name }}" data-user="{{ $schedule->user->name }}"
                        data-date="{{ $schedule->created_at->timestamp }}"
                        data-filename="{{ basename($schedule->attachment) }}"
                        data-type="{{ $schedule->file_type ?? 'other' }}">

                        {{-- Preview Area --}}
                        <div class="relative bg-gray-100 h-48 flex items-center justify-center overflow-hidden">
                            @php
                                $extension = strtolower(pathinfo($schedule->attachment, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp

                            @if ($isImage)
                                {{-- Image Preview --}}
                                <img src="{{ Storage::url($schedule->attachment) }}" alt="{{ $schedule->name }}"
                                    class="w-full h-full object-cover cursor-pointer hover:scale-110 transition duration-300"
                                    onclick="openPreviewModal('{{ Storage::url($schedule->attachment) }}', '{{ $schedule->name }}', 'image')">
                            @else
                                {{-- File Icon Based on Extension --}}
                                <div class="text-center cursor-pointer"
                                    onclick="openPreviewModal('{{ Storage::url($schedule->attachment) }}', '{{ $schedule->name }}', '{{ $extension }}')">
                                    @if (in_array($extension, ['pdf']))
                                        <svg class="w-20 h-20 text-red-500 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18.5,9H13V3.5L18.5,9M6,20V4H12V10H18V20H6Z" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-700 mt-2">PDF</p>
                                    @elseif(in_array($extension, ['doc', 'docx']))
                                        <svg class="w-20 h-20 text-blue-600 mx-auto" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-700 mt-2">WORD</p>
                                    @elseif(in_array($extension, ['xls', 'xlsx']))
                                        <svg class="w-20 h-20 text-green-600 mx-auto" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20M12.9,14.5L15.8,19H14L12,15.6L10,19H8.2L11.1,14.5L8.2,10H10L12,13.4L14,10H15.8L12.9,14.5Z" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-700 mt-2">EXCEL</p>
                                    @elseif(in_array($extension, ['zip', 'rar']))
                                        <svg class="w-20 h-20 text-yellow-600 mx-auto" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M14,17H12V15H14M14,13H12V11H14M10,9H12V7H10M10,13H12V11H10M10,17H12V15H10M14,9H12V7H14M20,19A2,2 0 0,1 18,21H6A2,2 0 0,1 4,19V7A2,2 0 0,1 6,5H10L12,7H18A2,2 0 0,1 20,9V19Z" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-700 mt-2">ZIP</p>
                                    @else
                                        <svg class="w-20 h-20 text-gray-500 mx-auto" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                                        </svg>
                                        <p class="text-sm font-medium text-gray-700 mt-2">{{ strtoupper($extension) }}</p>
                                    @endif
                                </div>
                            @endif

                            {{-- File Type Badge --}}
                            <span
                                class="absolute top-2 right-2 bg-white px-2 py-1 rounded-full text-xs font-semibold text-gray-700 shadow">
                                .{{ $extension }}
                            </span>
                        </div>

                        {{-- Info Area --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 truncate mb-1" title="{{ $schedule->name }}">
                                {{ $schedule->name }}
                            </h3>
                            <p class="text-xs text-gray-500 truncate mb-2" title="{{ basename($schedule->attachment) }}">
                                📎 {{ basename($schedule->attachment) }}
                            </p>

                            <div class="flex items-center justify-between text-xs text-gray-600 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $schedule->user->name }}
                                </span>
                                <span>{{ $schedule->created_at->diffForHumans() }}</span>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-2">
                                <a href="{{ Storage::url($schedule->attachment) }}" download
                                    class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-lg text-sm font-medium transition">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download
                                </a>
                                <a href="{{ route('schedules.index') }}"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-center py-2 rounded-lg text-sm font-medium transition">
                                    Lihat Jadwal
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada File</h3>
                    <p class="text-gray-500">Upload file melalui jadwal untuk melihatnya di sini</p>
                </div>
            @endforelse
        </div>

        {{-- No Results Message --}}
        <div id="noResults" class="hidden text-center py-12">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Hasil</h3>
            <p class="text-gray-500">Coba kata kunci lain atau ubah filter</p>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $schedules->links() }}
        </div>
    </div>

    {{-- Modal Preview --}}
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-75 hidden justify-center items-center z-50"
        onclick="closePreviewModal()">
        <div class="relative max-w-5xl max-h-[90vh] m-4" onclick="event.stopPropagation()">
            <button onclick="closePreviewModal()"
                class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl font-bold">
                ✕
            </button>
            <div id="previewContent" class="bg-white rounded-lg overflow-hidden shadow-2xl">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let allItems = [];

        document.addEventListener('DOMContentLoaded', function() {
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
                <img src="${url}" alt="${name}" class="max-w-full max-h-[80vh] object-contain">
                <div class="p-4 bg-gray-50">
                    <h3 class="font-semibold text-gray-800">${name}</h3>
                    <a href="${url}" download class="inline-block mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                        Download File
                    </a>
                </div>
            `;
            } else if (type === 'pdf') {
                content.innerHTML = `
                <iframe src="${url}" class="w-full h-[80vh]"></iframe>
                <div class="p-4 bg-gray-50">
                    <h3 class="font-semibold text-gray-800">${name}</h3>
                    <a href="${url}" download class="inline-block mt-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">
                        Download File
                    </a>
                </div>
            `;
            } else {
                content.innerHTML = `
                <div class="p-8 text-center">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">${name}</h3>
                    <p class="text-gray-600 mb-4">Preview tidak tersedia untuk tipe file ini</p>
                    <a href="${url}" download class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg font-medium">
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

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePreviewModal();
            }
        });
    </script>
@endpush
