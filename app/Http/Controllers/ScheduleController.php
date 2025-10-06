<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // user: buat jadwal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:5120',
        ]);

        if ($request->hasFile('attachment')) {
            // Ambil tanggal hari ini
            $tanggal = date('dmY');

            // Hitung berapa file yang sudah ada hari ini di folder storage
            $filesToday = collect(\Storage::disk('public')->files('attachments'))
                ->filter(function ($file) use ($tanggal) {
                    return str_contains($file, "_{$tanggal}");
                });

            // Nomor urut = jumlah file hari ini + 1
            $counter = $filesToday->count() + 1;

            // Format nama file 0001_tanggalbulantahun.ext
            $namaFile = sprintf(
                "%04d_%s.%s",
                $counter,
                $tanggal,
                $request->file('attachment')->getClientOriginalExtension()
            );

            // Simpan dengan nama custom
            $validated['attachment'] = $request->file('attachment')
                ->storeAs('attachments', $namaFile, 'public');
        }

        $validated['user_id'] = auth()->id();

        Schedule::create($validated);

        return redirect()->back()->with('success', 'Jadwal berhasil ditambahkan!');
    }


    // user: lihat jadwal sendiri
    public function index()
    {
        if (Auth::user()->is_admin) {
            $schedules = Schedule::with('user')->latest()->paginate(20);
        } else {
            $schedules = Auth::user()->schedules()->latest()->paginate(20);
        }


        return view('schedules.index', compact('schedules'));
    }

    public function dashboard()
    {
        
        if (Auth::user()->is_admin) {
            $schedules = Schedule::with('user')->latest()->paginate(20);
            $waitingSchedules = Schedule::where('status', 0)->count();
        } else {
            $schedules = Auth::user()->schedules()->latest()->paginate(20);
        }
        return view('dashboard', compact(['schedules', 'waitingSchedules']));
    }

    public function attachments()
    {
        $query = Schedule::whereNotNull('attachment')
            ->with('user')
            ->latest();

        // Jika bukan admin, hanya tampilkan milik user sendiri
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $schedules = $query->paginate(12);

        // Hitung total files
        $totalFiles = Schedule::whereNotNull('attachment')
            ->when(!auth()->user()->is_admin, function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->count();

        return view('schedules.attachment', compact('schedules', 'totalFiles'));
    }

    public function getSchedules()
    {
        if (Auth::user()->is_admin) {
            $schedules = Schedule::all()->map(function ($schedule) {
                return [
                    'id'          => $schedule->id,
                    'title'       => $schedule->name,
                    'start'       => \Carbon\Carbon::parse($schedule->scheduled_at)->toIso8601String(),
                    'end'         => \Carbon\Carbon::parse($schedule->scheduled_at)->addHours(2)->toIso8601String(), // contoh durasi 2 jam
                    'description' => $schedule->description,
                    'location'    => $schedule->location,
                ];
            });
        } else {
            $schedules = Auth::user()->schedules()->get()->map(function ($schedule) {
                return [
                    'id'          => $schedule->id,
                    'title'       => $schedule->name,
                    'start'       => \Carbon\Carbon::parse($schedule->scheduled_at)->toIso8601String(),
                    'end'         => \Carbon\Carbon::parse($schedule->scheduled_at)->addHours(2)->toIso8601String(),
                    'description' => $schedule->description,
                    'location'    => $schedule->location,
                ];
            });
        }

        return response()->json($schedules->values());
    }

    public function waitingSchedule()
    {
        $schedules = Schedule::where('status', 0)->latest()->paginate(20);

        return view('schedules.waiting', compact('schedules'));
    }

    // admin: edit/update/delete
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'description' => 'nullable|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($schedule->attachment) {
                Storage::disk('public')->delete($schedule->attachment);
            }

            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $schedule->update($validated);

        return redirect()->back()->with('success', 'Jadwal berhasil diupdate');
    }


    public function destroy(Schedule $schedule)
    {
        $this->authorize('manage', $schedule);
        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal dihapus');
    }

    public function updateStatus(Request $request, Schedule $schedule)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3,4'
        ]);

        $schedule->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status jadwal berhasil diubah');
    }
}
