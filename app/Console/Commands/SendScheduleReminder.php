<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Notifications\ScheduleReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendScheduleReminder extends Command
{
    protected $signature = 'schedules:send-reminders';
    protected $description = 'Kirim email reminder untuk jadwal yang jatuh besok';


    public function handle()
    {
        $tomorrowStart = Carbon::tomorrow()->startOfDay();
        $tomorrowEnd = Carbon::tomorrow()->endOfDay();


        $schedules = Schedule::whereBetween('start_time', [$tomorrowStart, $tomorrowEnd])
            ->whereNull('reminder_sent_at')
            ->with('user')
            ->get();


        foreach ($schedules as $schedule) {
            $schedule->user->notify(new ScheduleReminder($schedule));
            $schedule->update(['reminder_sent_at' => now()]);
            $this->info('Reminder sent for schedule ID: ' . $schedule->id);
        }


        return 0;
    }
}
