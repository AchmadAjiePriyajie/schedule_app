<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Illuminate\Console\Command;
use Carbon\Carbon;

class AutoUpdateScheduleStatus extends Command
{
    /**
     * Nama command.
     */
    protected $signature = 'schedule:auto-update-status';

    /**
     * Deskripsi command.
     */
    protected $description = 'Otomatis ubah status jadwal menjadi 1 (Accepted) jika lebih dari 24 jam belum di-update';

    public function handle()
    {
        $now = Carbon::now();

        // Ambil semua jadwal yang masih Pending (status = 0) dan sudah lewat 24 jam sejak dibuat
        $schedules = Schedule::where('status', 0)
            ->where('created_at', '<=', $now->subHours(24))
            ->get();

        $count = $schedules->count();

        foreach ($schedules as $schedule) {
            $schedule->update(['status' => 1]);
        }

        $this->info("Berhasil memperbarui {$count} jadwal menjadi Accepted.");
    }
}
