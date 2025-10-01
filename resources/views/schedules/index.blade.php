@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        {{-- Form Tambah Jadwal --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Tambah Jadwal Baru</h2>
            <form action="{{ route('schedules.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Nama Acara --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Acara <span class="text-red-500">*</span></label>
                    <input type="text" name="name"
                        class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required placeholder="Masukkan nama acara">
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        placeholder="Deskripsi acara (opsional)"></textarea>
                </div>

                {{-- Waktu Mulai & Selesai --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Waktu Mulai <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" name="start_time" id="start_time"
                            class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Waktu Selesai <span
                                class="text-red-500">*</span></label>
                        <input type="datetime-local" name="end_time" id="end_time"
                            class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required>
                    </div>
                </div>

                {{-- Lokasi dengan Search --}}
                <div class="relative">
                    <label class="block text-gray-700 font-medium mb-2">Cari Lokasi</label>
                    <input type="text" id="locationSearch"
                        class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        placeholder="Ketik nama tempat untuk mencari...">
                    <ul id="searchResults"
                        class="absolute bg-white border border-gray-200 rounded-lg mt-1 shadow-lg hidden max-h-60 overflow-y-auto z-50 w-full">
                    </ul>
                </div>

                {{-- Peta untuk Pick Location --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Pilih Lokasi dari Peta</label>
                    <div id="map" style="height: 350px; border: 1px solid #ccc; border-radius: 8px;"></div>
                    <p class="text-xs text-gray-500 mt-1">Klik pada peta atau drag marker untuk memilih lokasi</p>
                </div>

                {{-- Hidden fields untuk lokasi --}}
                <input type="hidden" name="location" id="location">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                {{-- Upload File --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Upload File Pendukung</label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition">
                        <input type="file" name="attachment" id="attachment" class="hidden"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip">
                        <label for="attachment" class="cursor-pointer">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <span class="text-sm text-gray-600">Klik untuk upload file</span>
                                <span class="text-xs text-gray-500 mt-1">PDF, DOC, XLS, JPG, PNG, ZIP (Max: 5MB)</span>
                            </div>
                        </label>
                    </div>
                    <div id="file-name" class="mt-2 text-sm text-gray-600 hidden">
                        <span class="font-medium">File terpilih:</span> <span id="file-name-text"></span>
                        <button type="button" onclick="clearFile()"
                            class="text-red-500 ml-2 hover:underline">Hapus</button>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-2.5 rounded-lg shadow-md transition duration-200">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Simpan Jadwal
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Jadwal --}}
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">📋 Daftar Jadwal</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Nama Acara</th>
                            <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Waktu Mulai</th>
                            <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Waktu Selesai</th>
                            <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Lokasi</th>
                            <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">File</th>
                            @if (auth()->user()->is_admin)
                                <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">User</th>
                            @endif
                            <th class="px-4 py-3 border text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($schedules as $schedule)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 border text-sm">{{ $schedule->id }}</td>
                                <td class="px-4 py-3 border text-sm font-medium text-gray-800">{{ $schedule->name }}</td>
                                <td class="px-4 py-3 border text-sm">
                                    {{ \Carbon\Carbon::parse($schedule->start_time ?? $schedule->scheduled_at)->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-3 border text-sm">
                                    {{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-4 py-3 border text-sm">{{ $schedule->location ?? '-' }}</td>
                                <td class="px-4 py-3 border text-sm">
                                    @if ($schedule->attachment)
                                        <a href="{{ Storage::url($schedule->attachment) }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-800 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            Download
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">Tidak ada file</span>
                                    @endif
                                </td>
                                @if (auth()->user()->is_admin)
                                    <td class="px-4 py-3 border text-sm">{{ $schedule->user->name }}</td>
                                @endif
                                <td class="px-4 py-3 border">
                                    <div class="flex space-x-2">
                                        <button onclick='openEditModal(@json($schedule))'
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow transition">
                                            Edit
                                        </button>
                                        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium shadow transition">
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
    </div>

    {{-- Modal Edit --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold mb-4">Edit Jadwal</h2>
            <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Acara</label>
                    <input type="text" name="name" id="editName"
                        class="w-full border border-gray-300 rounded-lg p-2.5" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="description" id="editDescription" rows="3"
                        class="w-full border border-gray-300 rounded-lg p-2.5"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" id="editStartTime"
                            class="w-full border border-gray-300 rounded-lg p-2.5" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Waktu Selesai</label>
                        <input type="datetime-local" name="end_time" id="editEndTime"
                            class="w-full border border-gray-300 rounded-lg p-2.5" required>
                    </div>
                </div>

                <div class="relative">
                    <label class="block text-gray-700 font-medium mb-2">Cari Lokasi</label>
                    <input type="text" id="editLocationSearch" class="w-full border border-gray-300 rounded-lg p-2.5"
                        placeholder="Ketik nama tempat...">
                    <ul id="editSearchResults"
                        class="absolute bg-white border border-gray-200 rounded-lg mt-1 shadow-lg hidden max-h-60 overflow-y-auto z-50 w-full">
                    </ul>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Pilih Lokasi dari Peta</label>
                    <div id="editMap" style="height: 300px; border: 1px solid #ccc; border-radius: 8px;"></div>
                </div>

                <input type="hidden" name="location" id="editLocation">
                <input type="hidden" name="latitude" id="editLatitude">
                <input type="hidden" name="longitude" id="editLongitude">

                <div id="currentFileDiv" class="hidden">
                    <label class="block text-gray-700 font-medium mb-2">File Saat Ini</label>
                    <div class="flex items-center space-x-2 bg-gray-50 p-3 rounded-lg">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <a id="currentFileLink" href="#" target="_blank"
                            class="text-blue-600 hover:underline">Lihat file</a>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Upload File Baru (Opsional)</label>
                    <input type="file" name="attachment" id="editAttachment"
                        class="w-full border border-gray-300 rounded-lg p-2.5"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip">
                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengganti file</p>
                </div>

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

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        let map, marker, editMap, editMarker;
        let mapInitialized = false;
        let editMapInitialized = false;

        // ===== FORM TAMBAH - INISIALISASI MAP =====
        document.addEventListener('DOMContentLoaded', function() {
            // Default Jakarta
            let defaultLat = -6.200000;
            let defaultLng = 106.816666;

            map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            // Update lokasi saat marker di-drag
            marker.on('dragend', function(e) {
                let pos = e.target.getLatLng();
                updateLocation(pos.lat, pos.lng, 'Lokasi dipilih dari map');
            });

            // Update lokasi saat klik map
            map.on('click', function(e) {
                marker.setLatLng([e.latlng.lat, e.latlng.lng]);
                updateLocation(e.latlng.lat, e.latlng.lng, 'Lokasi dipilih dari map');
            });

            mapInitialized = true;
        });

        // Update hidden fields lokasi (Form Tambah)
        function updateLocation(lat, lng, name = '') {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            if (name) {
                document.getElementById('location').value = name;
            }
        }

        // ===== SEARCH LOKASI - FORM TAMBAH =====
        document.getElementById('locationSearch').addEventListener('input', async function() {
            let query = this.value;
            let resultsList = document.getElementById('searchResults');

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
                            document.getElementById('locationSearch').value = place
                            .display_name;
                            updateLocation(place.lat, place.lon, place.display_name);
                            map.setView([place.lat, place.lon], 15);
                            marker.setLatLng([place.lat, place.lon]);
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

        // ===== VALIDASI WAKTU =====
        document.getElementById('start_time').addEventListener('change', function() {
            document.getElementById('end_time').setAttribute('min', this.value);
        });

        document.getElementById('end_time').addEventListener('change', function() {
            const startTime = document.getElementById('start_time').value;
            if (startTime && this.value && this.value < startTime) {
                alert('Waktu selesai harus lebih besar dari waktu mulai!');
                this.value = '';
            }
        });

        // ===== FILE UPLOAD PREVIEW =====
        document.getElementById('attachment').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file-name').classList.remove('hidden');
                document.getElementById('file-name-text').textContent = fileName;
            }
        });

        function clearFile() {
            document.getElementById('attachment').value = '';
            document.getElementById('file-name').classList.add('hidden');
        }

        // ===== MODAL EDIT =====
        function openEditModal(jadwal) {
            console.log('Opening modal with schedule:', jadwal);

            document.getElementById('editName').value = jadwal.name;
            document.getElementById('editDescription').value = jadwal.description ?? '';
            document.getElementById('editStartTime').value = (jadwal.start_time ?? jadwal.scheduled_at).replace(' ', 'T');
            document.getElementById('editEndTime').value = jadwal.end_time ? jadwal.end_time.replace(' ', 'T') : '';
            document.getElementById('editLocation').value = jadwal.location ?? '';
            document.getElementById('editLatitude').value = jadwal.latitude ?? '';
            document.getElementById('editLongitude').value = jadwal.longitude ?? '';

            if (jadwal.attachment) {
                document.getElementById('currentFileDiv').classList.remove('hidden');
                document.getElementById('currentFileLink').href = '/storage/' + jadwal.attachment;
            } else {
                document.getElementById('currentFileDiv').classList.add('hidden');
            }

            document.getElementById('editForm').action = `/schedules/${jadwal.id}`;

            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            let lat = jadwal.latitude || -6.200000;
            let lng = jadwal.longitude || 106.816666;

            setTimeout(() => {
                if (!editMapInitialized) {
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
                        editMarker.setLatLng([e.latlng.lat, e.latlng.lng]);
                        updateEditLocation(e.latlng.lat, e.latlng.lng, 'Lokasi dipilih dari map');
                    });

                    editMapInitialized = true;
                } else {
                    editMap.setView([lat, lng], 13);
                    editMarker.setLatLng([lat, lng]);
                    editMap.invalidateSize();
                }
            }, 100);
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

        // ===== SEARCH LOKASI - MODAL EDIT =====
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
                            updateEditLocation(place.lat, place.lon, place.display_name);
                            if (editMap) {
                                editMap.setView([place.lat, place.lon], 15);
                                editMarker.setLatLng([place.lat, place.lon]);
                            }
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

        // Validasi waktu di edit form
        document.getElementById('editStartTime')?.addEventListener('change', function() {
            document.getElementById('editEndTime').setAttribute('min', this.value);
        });

        document.getElementById('editEndTime')?.addEventListener('change', function() {
            const startTime = document.getElementById('editStartTime').value;
            if (startTime && this.value && this.value < startTime) {
                alert('Waktu selesai harus lebih besar dari waktu mulai!');
                this.value = '';
            }
        });

        // Close search results saat klik di luar
        document.addEventListener('click', function(e) {
            const searchInput = document.getElementById('locationSearch');
            const resultsList = document.getElementById('searchResults');
            const editSearchInput = document.getElementById('editLocationSearch');
            const editResultsList = document.getElementById('editSearchResults');

            if (e.target !== searchInput && !resultsList.contains(e.target)) {
                resultsList.classList.add('hidden');
            }
            if (e.target !== editSearchInput && !editResultsList.contains(e.target)) {
                editResultsList.classList.add('hidden');
            }
        });
    </script>
@endpush
