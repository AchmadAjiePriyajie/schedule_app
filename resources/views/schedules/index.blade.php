@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('schedules.index') }}"
            class="bg-white hover:bg-gray-50 p-2 rounded-lg border border-gray-200 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Tambah Jadwal Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Lengkapi form untuk menambahkan jadwal</p>
        </div>
    </div>

    {{-- Form Tambah Jadwal --}}
    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 overflow-hidden">
        <form action="{{ route('schedules.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            {{-- Nomor Surat --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nomor Permohonan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nomor_surat"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all"
                    required placeholder="Contoh: 001/SPT/2025">
            </div>

            {{-- Nama Acara --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Acara <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all"
                    required placeholder="Masukkan nama acara">
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="description" rows="4"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all resize-none"
                    placeholder="Deskripsi singkat mengenai acara (opsional)"></textarea>
            </div>

            {{-- Waktu Mulai & Selesai --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Waktu Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="start_time" id="start_time"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Waktu Selesai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="end_time" id="end_time"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all"
                        required>
                </div>
            </div>

            {{-- Lokasi dengan Search --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Cari Alamat <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" id="locationSearch"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pl-11 focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition-all"
                        placeholder="Ketik nama tempat untuk mencari...">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3.5 top-3"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <ul id="searchResults"
                        class="absolute bg-white border border-gray-200 rounded-xl mt-2 shadow-lg hidden max-h-60 overflow-y-auto z-[9999] w-full">
                    </ul>
                </div>
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Ketik minimal 3 karakter untuk mencari lokasi
                </p>
            </div>

            {{-- Peta untuk Pick Location --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Pilih Lokasi dari Peta
                </label>
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <div id="map" style="height: 400px;"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                    </svg>
                    Klik pada peta atau drag marker untuk memilih lokasi yang tepat
                </p>
            </div>

            {{-- Display Selected Location --}}
            <div id="selectedLocationDisplay"
                class="hidden bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-4">
                <div class="flex items-start gap-3">
                    <div class="bg-emerald-100 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-medium text-emerald-700 mb-1">Lokasi Terpilih</p>
                        <p id="selectedLocationText" class="text-sm text-gray-800 font-medium"></p>
                        <p class="text-xs text-gray-600 mt-1">
                            <span id="selectedCoordinates"></span>
                        </p>
                    </div>
                </div>
            </div>

            {{-- Hidden fields untuk lokasi --}}
            <input type="hidden" name="location" id="location" required>
            <input type="hidden" name="latitude" id="latitude" required>
            <input type="hidden" name="longitude" id="longitude" required>

            {{-- Upload File --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Upload File Pendukung <span class="text-red-500">*</span>
                </label>

                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition-all cursor-pointer"
                    onclick="document.getElementById('attachment').click()">
                    <input type="file" name="attachment" id="attachment" class="hidden"
                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip">
                    <div class="flex flex-col items-center">
                        <div class="bg-gradient-to-br from-emerald-100 to-teal-100 p-4 rounded-2xl mb-3">
                            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 mb-1">Klik untuk upload file</span>
                        <span class="text-xs text-gray-500">PDF, DOC, XLS, JPG, PNG, ZIP (Maksimal 5MB)</span>
                    </div>
                </div>

                <div id="file-preview"
                    class="hidden mt-4 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500">File Terpilih</p>
                                <p id="file-name-text" class="text-sm font-semibold text-gray-800"></p>
                            </div>
                        </div>
                        <button type="button" onclick="clearFile()"
                            class="text-red-500 hover:text-red-700 transition-colors p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('schedules.index') }}"
                    class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #searchResults {
            z-index: 9999 !important;
        }

        .leaflet-container {
            font-family: inherit;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 12px;
        }

        .leaflet-popup-content {
            margin: 12px 16px;
            font-size: 14px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        let map, marker;

        // ===== INISIALISASI MAP =====
        document.addEventListener('DOMContentLoaded', function () {
            // Default Jakarta
            let defaultLat = -6.200000;
            let defaultLng = 106.816666;

            map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            // Custom marker icon (green)
            const customIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            marker = L.marker([defaultLat, defaultLng], {
                draggable: true,
                icon: customIcon
            }).addTo(map);

            marker.bindPopup("<b>Drag marker ini</b><br>atau klik pada peta").openPopup();

            // Update lokasi saat marker di-drag
            marker.on('dragend', async function (e) {
                let pos = e.target.getLatLng();
                await reverseGeocode(pos.lat, pos.lng);
            });

            // Update lokasi saat klik map
            map.on('click', async function (e) {
                marker.setLatLng([e.latlng.lat, e.latlng.lng]);
                marker.openPopup();
                await reverseGeocode(e.latlng.lat, e.latlng.lng);
            });

            // Set initial location
            updateLocation(defaultLat, defaultLng, 'Jakarta, Indonesia (Default)');
        });

        // ===== REVERSE GEOCODING (Koordinat → Nama Lokasi) =====
        async function reverseGeocode(lat, lng) {
            try {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`;
                const response = await fetch(url);
                const data = await response.json();

                const locationName = data.display_name || 'Lokasi dipilih dari map';
                updateLocation(lat, lng, locationName);
                marker.bindPopup(`<b>${locationName}</b>`).openPopup();
            } catch (error) {
                console.error('Error reverse geocoding:', error);
                updateLocation(lat, lng, 'Lokasi dipilih dari map');
            }
        }

        // ===== UPDATE LOCATION DISPLAY =====
        function updateLocation(lat, lng, name = '') {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (name) {
                document.getElementById('location').value = name;
                document.getElementById('selectedLocationText').textContent = name;
            }

            document.getElementById('selectedCoordinates').textContent = `Lat: ${lat.toFixed(6)}, Lng: ${lng.toFixed(6)}`;
            document.getElementById('selectedLocationDisplay').classList.remove('hidden');
        }

        // ===== SEARCH LOKASI =====
        let searchTimeout;
        document.getElementById('locationSearch').addEventListener('input', async function () {
            let query = this.value;
            let resultsList = document.getElementById('searchResults');

            clearTimeout(searchTimeout);

            if (query.length < 3) {
                resultsList.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(async () => {
                try {
                    let url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&addressdetails=1&limit=5`;
                    let response = await fetch(url);
                    let data = await response.json();

                    resultsList.innerHTML = '';

                    if (data.length === 0) {
                        let li = document.createElement('li');
                        li.innerHTML = `
                                <div class="p-3 text-center">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <p class="text-sm text-gray-500">Tidak ada hasil ditemukan</p>
                                </div>
                            `;
                        resultsList.appendChild(li);
                    } else {
                        data.forEach(place => {
                            let li = document.createElement('li');
                            li.innerHTML = `
                                    <div class="p-3 hover:bg-emerald-50 cursor-pointer border-b last:border-b-0 transition-colors">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-800">${place.display_name}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            li.addEventListener('click', () => {
                                document.getElementById('locationSearch').value = place.display_name;
                                updateLocation(place.lat, place.lon, place.display_name);
                                map.setView([place.lat, place.lon], 16);
                                marker.setLatLng([place.lat, place.lon]);
                                marker.bindPopup(`<b>${place.display_name}</b>`).openPopup();
                                resultsList.classList.add('hidden');
                            });
                            resultsList.appendChild(li);
                        });
                    }
                    resultsList.classList.remove('hidden');
                } catch (error) {
                    console.error('Error searching location:', error);
                    resultsList.innerHTML = '<li class="p-3 text-center text-sm text-red-500">Terjadi kesalahan saat mencari</li>';
                    resultsList.classList.remove('hidden');
                }
            }, 500);
        });

        // ===== VALIDASI WAKTU =====
        document.getElementById('start_time').addEventListener('change', function () {
            document.getElementById('end_time').setAttribute('min', this.value);
        });

        document.getElementById('end_time').addEventListener('change', function () {
            const startTime = document.getElementById('start_time').value;
            if (startTime && this.value && this.value < startTime) {
                alert('Waktu selesai harus lebih besar dari waktu mulai!');
                this.value = '';
            }
        });

        // ===== FILE UPLOAD PREVIEW =====
        document.getElementById('attachment').addEventListener('change', function (e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file-preview').classList.remove('hidden');
                document.getElementById('file-name-text').textContent = fileName;
            }
        });

        function clearFile() {
            document.getElementById('attachment').value = '';
            document.getElementById('file-preview').classList.add('hidden');
        }

        // ===== CLOSE SEARCH RESULTS =====
        document.addEventListener('click', function (e) {
            const searchInput = document.getElementById('locationSearch');
            const resultsList = document.getElementById('searchResults');

            if (e.target !== searchInput && !resultsList.contains(e.target)) {
                resultsList.classList.add('hidden');
            }
        });
    </script>
@endpush