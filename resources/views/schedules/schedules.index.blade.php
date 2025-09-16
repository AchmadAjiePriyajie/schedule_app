@extends('layouts.app')
<input type="text" name="name" class="w-full border rounded p-2" required>
</div>
<div class="mb-3">
    <label class="block text-gray-700">Tanggal & Waktu</label>
    <input type="datetime-local" name="scheduled_at" class="w-full border rounded p-2" required>
</div>
<div class="mb-3">
    <label class="block text-gray-700">Lokasi</label>
    <input type="text" name="location" class="w-full border rounded p-2">
</div>
<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
</form>
</div>


{{-- Tabel Jadwal --}}
<div class="bg-white shadow rounded p-4">
    <h2 class="text-xl font-semibold mb-3">Jadwal Anda</h2>
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
                        {{-- Edit Jadwal --}}
                        <form action="{{ route('schedules.update', $schedule) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $schedule->name }}">
                            <input type="hidden" name="scheduled_at" value="{{ $schedule->scheduled_at }}">
                            <input type="hidden" name="location" value="{{ $schedule->location }}">
                            <button type="submit" class="bg-yellow-400 px-2 py-1 rounded">Edit</button>
                        </form>


                        {{-- Hapus Jadwal --}}
                        <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline"
                            onsubmit="return confirm('Yakin hapus jadwal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
</div>
</div>
@endsection
