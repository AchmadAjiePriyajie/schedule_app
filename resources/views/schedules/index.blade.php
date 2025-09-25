@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Daftar Jadwal</h1>

        {{-- Form Tambah Jadwal --}}
        <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Buat Jadwal</h2>
            <form method="POST" action="{{ route('schedules.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-600 mb-1">Nama Acara</label>
                    <input type="text" name="name"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required>
                </div>

                <div>
                    <label class="block text-gray-600 mb-1">Deskripsi</label>
                    <textarea name="description"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"></textarea>
                </div>

                <div>
                    <label class="block text-gray-600 mb-1">Waktu</label>
                    <input type="datetime-local" name="scheduled_at"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required>
                </div>

                <div class="relative">
                    <label class="block text-gray-600 mb-1">Cari Lokasi</label>
                    <input type="text" id="location-search"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        placeholder="Cari nama tempat...">

                    {{-- Dropdown hasil pencarian --}}
                    <ul id="search-results"
                        class="absolute left-0 right-0 bg-white border border-gray-200 rounded-lg mt-1 shadow-lg hidden max-h-60 overflow-y-auto z-50">
                    </ul>
                </div>

                <input type="hidden" name="location" id="location">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">Simpan</button>
            </form>
        </div>

        {{-- Tabel Jadwal --}}
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
                                    <button
                                        onclick="openEditModal({{ $schedule->id }}, '{{ $schedule->name }}', '{{ $schedule->scheduled_at }}', '{{ $schedule->location }}')"
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
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-lg font-bold mb-4">Edit Jadwal</h2>
                <form id="editForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-gray-600 mb-1">Nama Acara</label>
                        <input type="text" name="name" id="editName"
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required>
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-1">Tanggal & Waktu</label>
                        <input type="datetime-local" name="scheduled_at" id="editDatetime"
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                            required>
                    </div>
                    <div>
                        <label class="block text-gray-600 mb-1">Lokasi</label>
                        <input type="text" name="location" id="editLocation"
                            class="w-full border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
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
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('location-search').addEventListener('input', async function() {
            let query = this.value;
            let resultsList = document.getElementById('search-results');
            resultsList.innerHTML = '';
            resultsList.classList.add('hidden');

            if (query.length < 3) return;

            let res = await fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`);
            let data = await res.json();

            if (data.length > 0) {
                resultsList.classList.remove('hidden');
            }

            data.forEach(place => {
                let li = document.createElement('li');
                li.classList.add('px-3', 'py-2', 'hover:bg-gray-100', 'cursor-pointer', 'text-sm');
                li.textContent = place.display_name;

                li.addEventListener('click', () => {
                    document.getElementById('location').value = place.display_name;
                    document.getElementById('latitude').value = place.lat;
                    document.getElementById('longitude').value = place.lon;
                    document.getElementById('location-search').value = place.display_name;
                    resultsList.innerHTML = '';
                    resultsList.classList.add('hidden');
                });

                resultsList.appendChild(li);
            });
        });

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function(e) {
            if (!document.getElementById('location-search').contains(e.target) &&
                !document.getElementById('search-results').contains(e.target)) {
                document.getElementById('search-results').classList.add('hidden');
            }
        });


        function openEditModal(id, name, datetime, location) {
            document.getElementById('editForm').action = '/schedules/' + id;
            document.getElementById('editName').value = name;
            document.getElementById('editDatetime').value = datetime.replace(' ', 'T');
            document.getElementById('editLocation').value = location;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
    </script>
@endsection
