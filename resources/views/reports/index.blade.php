@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Laporan Jadwal & Surat</h1>

    <form method="GET" action="{{ route('reports.index') }}" class="mb-6 flex items-end gap-4">
        <div>
            <label for="start_date" class="block text-sm font-medium">Dari Tanggal</label>
            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                class="border rounded-md px-2 py-1 w-48">
        </div>
        <div>
            <label for="end_date" class="block text-sm font-medium">Sampai Tanggal</label>
            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                class="border rounded-md px-2 py-1 w-48">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Filter
        </button>
        <a href="{{ route('reports.export', request()->only('start_date', 'end_date')) }}"
            class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
            Export Excel
        </a>
    </form>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full text-sm border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-3 py-2 border">No</th>
                    <th class="px-3 py-2 border">Nama Kegiatan</th>
                    <th class="px-3 py-2 border">Nomor Surat</th>
                    <th class="px-3 py-2 border">Lokasi</th>
                    <th class="px-3 py-2 border">Waktu Mulai</th>
                    <th class="px-3 py-2 border">Waktu Selesai</th>
                    <th class="px-3 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $item)
                    <tr>
                        <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-3 py-2">{{ $item->name }}</td>
                        <td class="border px-3 py-2">{{ $item->nomor_surat }}</td>
                        <td class="border px-3 py-2">{{ $item->location }}</td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($item->start_time)->format('d M Y H:i') }}
                        </td>
                        <td class="border px-3 py-2">{{ \Carbon\Carbon::parse($item->end_time)->format('d M Y H:i') }}</td>
                        <td class="border px-3 py-2">
                            @if($item->status == 1)
                                <span class="text-green-600 font-semibold">Disetujui</span>
                            @elseif($item->status == 2)
                                <span class="text-yellow-600 font-semibold">Menunggu</span>
                            @else
                                <span class="text-red-600 font-semibold">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-3">Tidak ada data ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
</div>
@endsection