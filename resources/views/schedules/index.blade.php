@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Daftar Jadwal</h1>

    {{-- Form Tambah Jadwal --}}
    <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-xl font-semibold mb-3">Buat Jadwal Baru</h2>
        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block">Nama Acara</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label class="block">Tanggal & Waktu</label>
                <input type="datetime-local" name="scheduled_at" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-3">
                <label class="block">Lokasi</label>
                <input type="text" name="location" class="w-full border rounded p-2">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
        </form>
    </div>

    {{-- Tabel Jadwal --}}
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-xl font-semibold mb-3">Jadwal</h2>
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Nama Acara</th>
                    <th class="border p-2">Tanggal & Waktu</th>
                    <th class="border p-2">Lokasi</th>
                    @if (auth()->user()->is_admin)
                        <th class="border p-2">User</th>
                    @endif
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    <tr>
                        <td class="border p-2">{{ $schedule->id }}</td>
                        <td class="border p-2">{{ $schedule->name }}</td>
                        <td class="border p-2">{{ $schedule->scheduled_at->format('d M Y H:i') }}</td>
                        <td class="border p-2">{{ $schedule->location ?? '-' }}</td>
                        @if (auth()->user()->is_admin)
                            <td class="border p-2">{{ $schedule->user->name }}</td>
                        @endif
                        <td class="border p-2 flex space-x-2">
                            <button
                                onclick="openEditModal({{ $schedule->id }}, '{{ $schedule->name }}', '{{ $schedule->scheduled_at }}', '{{ $schedule->location }}')"
                                class="bg-yellow-400 px-2 py-1 rounded">Edit</button>
                            <form action="{{ route('schedules.destroy', $schedule) }}" method="POST"
                                onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $schedules->links() }}</div>
    </div>

    {{-- Modal Edit Jadwal --}}
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded shadow w-96">
            <h2 class="text-lg font-bold mb-4">Edit Jadwal</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama Acara</label>
                    <input type="text" name="name" id="editName" class="w-full border rounded p-2" required>
                </div>
                <div class="mb-3">
                    <label>Tanggal & Waktu</label>
                    <input type="datetime-local" name="scheduled_at" id="editDatetime" class="w-full border rounded p-2"
                        required>
                </div>
                <div class="mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="location" id="editLocation" class="w-full border rounded p-2">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="px-3 py-1 border rounded">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
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
