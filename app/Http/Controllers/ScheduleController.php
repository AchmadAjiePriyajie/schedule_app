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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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
    public function update(Request $request, Schedule $schedule)
    {
        $this->authorize('manage', $schedule); // policy (lihat di bawah)


        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date|after_or_equal:now',
            'location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
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
