<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'location' => 'required|string|max:255',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'nomor_surat' => 'required|string|unique:schedules,nomor_surat',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:5120',
            ]);

            if ($request->hasFile('attachment')) {
                // Ambil tanggal hari ini
                $tanggal = date('dmY');

                // Hitung berapa file yang sudah ada hari ini di folder storage
                $filesToday = collect(\Storage::disk('public')->files('attachments'))
                    ->filter(fn($file) => str_contains($file, "_{$tanggal}"));

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
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                // kode 23000 = pelanggaran constraint, seperti duplikat unique
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Nomor surat sudah digunakan. Silakan gunakan nomor lain.');
            }

            // Error lain
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan pada database: ' . $e->getMessage());
        }
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
            $waitingSchedules = 0;

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

    public function getSchedules(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        // Tentukan query sesuai role user
        if (Auth::user()->is_admin) {
            $query = Schedule::where('status', '!=', 0);
        } else {
            $query = Auth::user()
                ->schedules()
                ->where('status', '!=', 0);
        }

        // Filter event berdasarkan rentang tanggal yang sedang dilihat di kalender
        if ($start && $end) {
            $query->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        // Event yang dimulai sebelum start tapi berakhir sesudah end
                        $q2->where('start_time', '<', $start)
                            ->where('end_time', '>', $end);
                    });
            });
        }

        // Ambil semua event dan ubah jadi format FullCalendar
        $schedules = $query->get()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'title' => $schedule->name,
                'start' => \Carbon\Carbon::parse($schedule->start_time)->toIso8601String(),
                'end' => \Carbon\Carbon::parse($schedule->end_time)->toIso8601String(),
                'description' => $schedule->description,
                'location' => $schedule->location,
                'allDay' => false, // tampil tanpa jam (full day)
                'backgroundColor' => '#3b82f6',
                'borderColor' => '#2563eb',
                'textColor' => '#ffffff',
                'status' => $schedule->status,
            ];
        });

        return response()->json($schedules->values());
    }






    public function waitingSchedule(Request $request)
    {
        $query = Schedule::query();

        // Filter tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_time', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('start_time', '<=', $request->end_date);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('start_time', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('start_time', 'desc'); // latest
                break;
        }

        // Jika admin, tampilkan semua; jika bukan, tampilkan milik user
        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $schedules = $query->paginate(10)->withQueryString();
        return view('schedules.waiting', compact('schedules'));
    }

    // admin: edit/update/delete
    public function update(Request $request, $id)
    {

        // dd('masuk ke controller', $request->all());

        // dd('masuk', $id);
        $schedule = Schedule::findOrFail($id);


        // dd($schedule->name);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            // 'nomor_surat' => 'required|string|unique:schedules,nomor_surat,' . $schedule->id,
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip|max:5120',
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
