@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            📅 Dashboard Kalender Jadwal
        </h1>
        <button onclick="calendar.today()" 
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
            Hari Ini
        </button>
    </div>

    <!-- Statistik -->
    @if (auth()->user()->is_admin)
        
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4 hover:shadow-lg transition">
            <div class="bg-blue-100 text-blue-600 p-3 rounded-full text-2xl">📊</div>
            <div>
                <p class="text-sm text-gray-500">Total Jadwal</p>
                <h3 class="text-xl font-bold">{{ $totalSchedules ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4 hover:shadow-lg transition">
            <div class="bg-green-100 text-green-600 p-3 rounded-full text-2xl">✅</div>
            <div>
                <p class="text-sm text-gray-500">Hari Ini</p>
                <h3 class="text-xl font-bold">{{ $todaySchedules ?? 0 }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4 hover:shadow-lg transition">
            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full text-2xl">⏳</div>
            <div>
                <p class="text-sm text-gray-500">Menunggu</p>
                <h3 class="text-xl font-bold">{{ $waitingSchedules ?? 0 }}</h3>
            </div>
        </div>
    </div>
    
    @endif
    <!-- Kalender -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div id="calendar"></div>
    </div>
</div>

<!-- Modal Detail Event -->
<div id="eventModal" 
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <h2 id="modalTitle" class="text-xl font-bold mb-2">Detail Acara</h2>
        <p id="modalTime" class="text-gray-600 mb-2"></p>
        <p id="modalLocation" class="text-gray-600 mb-2"></p>
        <p id="modalDescription" class="text-gray-700"></p>
        <div class="mt-4 text-right">
            <button onclick="closeModal()" 
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<style>
    /* Biar calendar lebih smooth */
    #calendar .fc-daygrid-event {
        border-radius: 6px;
        padding: 3px 5px;
        font-size: 0.875rem;
        transition: transform 0.2s;
    }
    #calendar .fc-daygrid-event:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    let calendar;

    function openModal(event) {
        document.getElementById('modalTitle').textContent = event.title;
        document.getElementById('modalTime').textContent = 
            "🕒 " + (event.start ? event.start.toLocaleString('id-ID') : '-') +
            (event.end ? " - " + event.end.toLocaleString('id-ID') : "");
        document.getElementById('modalLocation').textContent = "📍 " + (event.extendedProps.location || '-');
        document.getElementById('modalDescription').textContent = "📝 " + (event.extendedProps.description || '-');
        document.getElementById('eventModal').classList.remove('hidden');
        document.getElementById('eventModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('eventModal').classList.add('hidden');
        document.getElementById('eventModal').classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            events: '/api/schedules',
            eventDidMount: function(info) {
                let el = info.el;
                el.style.backgroundColor = info.event.backgroundColor || "#3b82f6";
                el.style.borderColor = info.event.borderColor || "#2563eb";
                el.style.color = "white";
            },
            eventClick: function(info) {
                openModal(info.event);
            }
        });

        calendar.render();
    });
</script>
@endpush
