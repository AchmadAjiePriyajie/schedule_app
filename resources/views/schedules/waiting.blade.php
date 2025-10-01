@extends('layouts.app')

@section('content')
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-700">Jadwal</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nama Acara</th>
                        <th class="px-4 py-2 border">Tanggal & Waktu</th>
                        <th class="px-4 py-2 border">Lokasi</th>
                        @if (auth()->user()->is_admin)
                            <th class="px-4 py-2 border">User</th>
                        @endif
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach ($schedules as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $schedule->id }}</td>
                            <td class="px-4 py-2 border">{{ $schedule->name }}</td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border">{{ $schedule->location ?? '-' }}</td>
                            @if (auth()->user()->is_admin)
                                <td class="px-4 py-2 border">{{ $schedule->user->name }}</td>
                            @endif
                            <td class="px-4 py-2 border flex space-x-2">
                                <button onclick='openEditModal(@json($schedule))'
                                    class="bg-yellow-400 hover:bg-yellow-500 px-3 py-1 rounded-lg text-white shadow">Edit</button>
                                <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                                    onsubmit="return confirm('Hapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg shadow">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $schedules->links() }}</div>
    </div>

    {{-- Modal Edit Jadwal --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h2 class="text-lg font-bold mb-4">Edit Jadwal</h2>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Nama acara --}}
                <div>
                    <label class="block text-gray-600 mb-1">Nama Acara</label>
                    <input type="text" name="name" id="editName"
                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required>
                </div>

                {{-- Tanggal & Waktu --}}
                <div>
                    <label class="block text-gray-600 mb-1">Tanggal & Waktu</label>
                    <input type="datetime-local" name="scheduled_at" id="editDatetime"
                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-gray-600 mb-1">Deskripsi Acara</label>
                    <textarea name="description" id="editDescription" rows="3"
                        class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"></textarea>
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
        /* Fix untuk marker icon Leaflet */
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

        // Fungsi untuk buka modal edit
        function openEditModal(jadwal) {
            console.log('Opening modal with schedule:', jadwal);

            // Isi field form
            document.getElementById('editName').value = jadwal.name;
            document.getElementById('editDatetime').value = jadwal.scheduled_at.replace(' ', 'T');
            document.getElementById('editDescription').value = jadwal.description ?? '';
            document.getElementById('editLocation').value = jadwal.location ?? '';
            document.getElementById('editLatitude').value = jadwal.latitude ?? '';
            document.getElementById('editLongitude').value = jadwal.longitude ?? '';

            // Update action form
            document.getElementById('editForm').action = `/schedules/${jadwal.id}`;

            // Tampilkan modal dengan flex
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Default koordinat (Jakarta jika tidak ada data)
            let lat = jadwal.latitude || -6.200000;
            let lng = jadwal.longitude || 106.816666;

            // Inisialisasi map setelah modal tampil
            setTimeout(() => {
                if (!mapInitialized) {
                    console.log('Initializing map for the first time');

                    // Inisialisasi map
                    editMap = L.map('editMap').setView([lat, lng], 13);

                    // Tile dari OSM
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap'
                    }).addTo(editMap);

                    // Tambahkan marker
                    editMarker = L.marker([lat, lng], {
                        draggable: true
                    }).addTo(editMap);

                    // Event drag marker
                    editMarker.on('dragend', function(e) {
                        let pos = e.target.getLatLng();
                        updateEditLocation(pos.lat, pos.lng, 'Lokasi dipilih dari map');
                    });

                    // Klik map untuk pindahkan marker
                    editMap.on('click', function(e) {
                        let lat = e.latlng.lat;
                        let lng = e.latlng.lng;
                        editMarker.setLatLng([lat, lng]);
                        updateEditLocation(lat, lng, 'Lokasi dipilih dari map');
                    });

                    mapInitialized = true;
                } else {
                    console.log('Updating existing map');
                    // Update posisi map dan marker kalau map sudah ada
                    editMap.setView([lat, lng], 13);
                    editMarker.setLatLng([lat, lng]);

                    // Invalidate size untuk refresh map
                    editMap.invalidateSize();
                }
            }, 100);
        }

        // Fungsi untuk close modal edit
        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Update hidden field lokasi
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

                            // Pindahkan map + marker
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

        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            const searchInput = document.getElementById('editLocationSearch');
            const resultsList = document.getElementById('editSearchResults');

            if (e.target !== searchInput && !resultsList.contains(e.target)) {
                resultsList.classList.add('hidden');
            }
        });
    </script>
@endpush
