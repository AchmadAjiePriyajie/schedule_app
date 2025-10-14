@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Jadwal</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Nama Acara</th>
                        <th class="px-4 py-2 border">Tanggal & Waktu</th>
                        <th class="px-4 py-2 border">Lokasi</th>
                        @if (auth()->user()->is_admin)
                            <th class="px-4 py-2 border">User</th>
                        @endif
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Surat</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($schedules as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $schedule->name }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border">{{ $schedule->location ?? '-' }}</td>
                            @if (auth()->user()->is_admin)
                                <td class="px-4 py-2 border">{{ $schedule->user->name }}</td>
                            @endif
                            <td class="px-4 py-2 border">
                                @php
                                    $statusConfig = [
                                        0 => ['label' => 'Pending', 'class' => 'bg-yellow-100 text-yellow-800'],
                                        1 => ['label' => 'Accepted', 'class' => 'bg-green-100 text-green-800'],
                                        2 => ['label' => 'On Going', 'class' => 'bg-blue-100 text-blue-800'],
                                        3 => ['label' => 'Finished', 'class' => 'bg-gray-100 text-gray-800'],
                                        4 => ['label' => 'Cancelled', 'class' => 'bg-red-100 text-red-800'],
                                    ];
                                    $currentStatus = $statusConfig[$schedule->status] ?? $statusConfig[0];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $currentStatus['class'] }}">
                                    {{ $currentStatus['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                @if ($schedule->attachment)
                                    @php
                                        $extension = pathinfo($schedule->attachment, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), [
                                            'jpg',
                                            'jpeg',
                                            'png',
                                            'gif',
                                            'webp',
                                        ]);
                                        $isPdf = strtolower($extension) === 'pdf';
                                    @endphp

                                    @if ($isImage)
                                        <button
                                            onclick='showAttachment("{{ asset('storage/' . $schedule->attachment) }}", "image", "{{ $schedule->name }}")'
                                            class="inline-flex items-center gap-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Lihat
                                        </button>
                                    @elseif ($isPdf)
                                        <a href="{{ asset('storage/' . $schedule->attachment) }}" target="_blank"
                                            class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            PDF
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $schedule->attachment) }}" download
                                            class="inline-flex items-center gap-1 bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded-lg text-xs">
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
                            <td class="px-4 py-2 border">
                                <div class="flex flex-wrap gap-2">
                                    <button onclick='openStatusModal(@json($schedule))'
                                        class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-lg text-white shadow text-sm">
                                        Status
                                    </button>
                                    <button onclick='openEditModal(@json($schedule))'
                                        class="bg-yellow-400 hover:bg-yellow-500 px-3 py-1 rounded-lg text-white shadow text-sm">
                                        Edit
                                    </button>
                                    <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                                        onsubmit="return confirm('Hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow text-sm">
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
        <div class="mt-4">{{ $schedules->links() }}</div>
    </div>

    {{-- Modal Preview Attachment --}}
    <div id="attachmentModal" class="fixed inset-0 bg-black bg-opacity-75 hidden justify-center items-center z-50">
        <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 id="attachmentTitle" class="text-lg font-bold text-gray-800"></h3>
                <button onclick="closeAttachmentModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="attachmentContent" class="flex justify-center">
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
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
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

                    editMarker.on('dragend', function(e) {
                        let pos = e.target.getLatLng();
                        updateEditLocation(pos.lat, pos.lng, 'Lokasi dipilih dari map');
                    });

                    editMap.on('click', function(e) {
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
        document.getElementById('editLocationSearch').addEventListener('input', async function() {
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

        document.addEventListener('click', function(e) {
            const searchInput = document.getElementById('editLocationSearch');
            const resultsList = document.getElementById('editSearchResults');

            if (e.target !== searchInput && !resultsList.contains(e.target)) {
                resultsList.classList.add('hidden');
            }
        });
    </script>
@endpush
