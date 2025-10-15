<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SchedulesExport;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::query();

        // Filter berdasarkan rentang waktu
        if ($request->filled('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_time', '<=', $request->end_date);
        }

        $schedules = $query->orderBy('start_time', 'desc')->paginate(10);

        return view('reports.index', compact('schedules'));
    }

    public function export(Request $request)
    {
        $filename = 'Laporan_Jadwal_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new SchedulesExport($request->start_date, $request->end_date), $filename);
    }
}
