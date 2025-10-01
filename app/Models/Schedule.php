<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'scheduled_at',
        'start_time',
        'end_time',
        'location',
        'latitude',
        'longitude',
        'attachment'
    ];

    protected $dates = ['scheduled_at', 'reminder_sent_at', 'created_at', 'updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }



    protected $casts = [
        'scheduled_at' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
