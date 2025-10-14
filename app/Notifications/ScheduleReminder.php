<?php

namespace App\Notifications;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ScheduleReminder extends Notification
{
    use Queueable;

    protected $schedule;
    /**
     * Create a new notification instance.
     */
    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pengingat: ' . $this->schedule->name)
            ->line('Ini pengingat untuk acara: ' . $this->schedule->name)
            ->line('Waktu: ' . $this->schedule->start_time->format('d M Y H:i') . '- ' . $this->schedule->end_time->format('d M Y H:i'))
            ->line('Lokasi: ' . ($this->schedule->location ?? '-'))
            ->action('Lihat Jadwal', url(route('schedules.index')))
            ->line('Terima kasih.');
    }
}
