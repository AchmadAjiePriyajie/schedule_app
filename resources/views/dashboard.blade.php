@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header Section -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Kalender Jadwal</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola dan pantau jadwal Anda</p>
            </div>
            @if (auth()->user()->is_admin)
                <a href="{{ route('schedules.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-lg hover:shadow-lg transition-all duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="font-medium">Tambah Jadwal</span>
                </a>
            @endif
        </div>

        <!-- Statistics Cards -->
        @if (auth()->user()->is_admin)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- Total Schedules Card -->
                <div
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-gray-50 to-gray-100 rounded-full -mr-16 -mt-16 opacity-50">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 mb-1">Total Jadwal</p>
                                <h3 class="text-3xl font-bold text-gray-800">{{ $totalSchedules ?? 0 }}</h3>
                                <p class="text-xs text-gray-400 mt-2">Semua jadwal terdaftar</p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-gray-100 to-gray-200 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="h-1 bg-gradient-to-r from-gray-400 to-gray-500 group-hover:h-1.5 transition-all duration-300">
                    </div>
                </div>

                <!-- Today Schedules Card -->
                <div
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-emerald-100">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-full -mr-16 -mt-16 opacity-50">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 mb-1">Hari Ini</p>
                                <h3 class="text-3xl font-bold text-emerald-600">{{ $todaySchedules ?? 0 }}</h3>
                                <p class="text-xs text-gray-400 mt-2">Jadwal aktif hari ini</p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-emerald-100 to-teal-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="h-1 bg-gradient-to-r from-emerald-400 to-teal-500 group-hover:h-1.5 transition-all duration-300">
                    </div>
                </div>

                <!-- Waiting Schedules Card -->
                <div
                    class="group relative overflow-hidden bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 border border-amber-100">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-50 to-orange-50 rounded-full -mr-16 -mt-16 opacity-50">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 mb-1">Menunggu</p>
                                <h3 class="text-3xl font-bold text-amber-600">{{ $waitingSchedules ?? 0 }}</h3>
                                <p class="text-xs text-gray-400 mt-2">Perlu persetujuan</p>
                            </div>
                            <div
                                class="bg-gradient-to-br from-amber-100 to-orange-100 p-3 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div
                        class="h-1 bg-gradient-to-r from-amber-400 to-orange-500 group-hover:h-1.5 transition-all duration-300">
                    </div>
                </div>

            </div>
        @endif
        <!-- Calendar Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div id="calendar"></div>
            </div>
        </div>

    </div>

    <!-- Modal Detail Event -->
    <div id="eventModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4"
        onclick="closeModal()">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all"
            onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 rounded-t-2xl">
                <h2 id="modalTitle" class="text-xl font-bold text-white">Detail Acara</h2>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <div class="bg-emerald-50 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 mb-1">Waktu</p>
                        <p id="modalTime" class="text-sm text-gray-700 font-medium"></p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="bg-blue-50 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 mb-1">Lokasi</p>
                        <p id="modalLocation" class="text-sm text-gray-700 font-medium"></p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="bg-purple-50 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 mb-1">Deskripsi</p>
                        <p id="modalDescription" class="text-sm text-gray-700"></p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 bg-gray-50 rounded-b-2xl">
                <button onclick="closeModal()"
                    class="w-full px-4 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white rounded-lg transition-all duration-300 font-medium">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
        /* Calendar Customization */
        #calendar {
            font-family: inherit;
        }

        .fc .fc-button {
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            border: none;
            padding: 8px 16px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .fc .fc-button:hover {
            background: linear-gradient(135deg, #047857 0%, #0f766e 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
        }

        .fc .fc-button:disabled {
            background: #e5e7eb;
            opacity: 0.5;
        }

        .fc .fc-button-active {
            background: linear-gradient(135deg, #047857 0%, #0f766e 100%) !important;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: #f3f4f6;
        }

        .fc .fc-col-header-cell {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 12px 8px;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .fc .fc-daygrid-day-number {
            padding: 8px;
            font-weight: 600;
            color: #6b7280;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%) !important;
        }

        .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 4px;
        }

        .fc .fc-daygrid-event {
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.813rem;
            font-weight: 500;
            border: none;
            margin: 2px 3px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .fc .fc-daygrid-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .fc .fc-daygrid-day-frame {
            min-height: 100px;
        }

        /* Modal Animation */
        #eventModal.flex {
            animation: fadeIn 0.2s ease-out;
        }

        #eventModal.flex>div {
            animation: slideUp 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
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
                (event.start ? event.start.toLocaleString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                }) : '-') +
                (event.end ? " sampai " + event.end.toLocaleString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                }) : "");
            document.getElementById('modalLocation').textContent = event.extendedProps.location || 'Tidak ada lokasi';
            document.getElementById('modalDescription').textContent = event.extendedProps.description ||
                'Tidak ada deskripsi';
            document.getElementById('eventModal').classList.remove('hidden');
            document.getElementById('eventModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('eventModal').classList.add('hidden');
            document.getElementById('eventModal').classList.remove('flex');
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            let calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                locale: 'id',
                displayEventEnd: true,
                eventDisplay: 'block',
                expandRows: true,
                timeZone: 'Asia/Jakarta',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari',
                    list: 'Agenda'
                },
                events: '/api/schedules',

                eventDidMount: function(info) {
                    let el = info.el;
                    let status = info.event.extendedProps.status;

                    // Color mapping based on status with softer gray tones
                    const colorMap = {
                        0: {
                            bg: '#fbbf24',
                            text: '#78350f'
                        }, // Pending (amber)
                        1: {
                            bg: '#10b981',
                            text: '#ffffff'
                        }, // Accepted (emerald)
                        2: {
                            bg: '#3b82f6',
                            text: '#ffffff'
                        }, // On Going (blue)
                        3: {
                            bg: '#9ca3af',
                            text: '#ffffff'
                        }, // Finished (gray)
                        4: {
                            bg: '#ef4444',
                            text: '#ffffff'
                        } // Cancelled (red)
                    };

                    const colors = colorMap[status] || {
                        bg: '#e5e7eb',
                        text: '#374151'
                    };

                    el.style.backgroundColor = colors.bg;
                    el.style.color = colors.text;
                    el.style.borderLeft = `3px solid ${colors.bg}`;
                    el.style.fontWeight = '500';
                },

                eventClick: function(info) {
                    openModal(info.event);
                }
            });

            calendar.render();
        });
    </script>
@endpush
