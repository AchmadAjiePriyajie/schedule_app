<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // user: buat jadwal
    public function store(Request $req)
    {
        $data = $req->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
        ]);


        $schedule = Schedule::create(array_merge($data, ['user_id' => Auth::id()]));


        return redirect()->back()->with('success', 'Jadwal dibuat');
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


    // admin: edit/update/delete
    public function update(Request $req, Schedule $schedule)
    {
        $this->authorize('manage', $schedule); // policy (lihat di bawah)


        $data = $req->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
        ]);


        $schedule->update($data);


        return redirect()->back()->with('success', 'Jadwal diperbarui');
    }


    public function destroy(Schedule $schedule)
    {
        $this->authorize('manage', $schedule);
        $schedule->delete();
        return redirect()->back()->with('success', 'Jadwal dihapus');
    }
}
