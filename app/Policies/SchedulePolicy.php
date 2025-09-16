<?php

namespace App\Policies;

use App\Models\Schedule;
use App\Models\User;

class SchedulePolicy
{
    /**
     * Create a new policy instance.
     */
    public function manage(User $user, Schedule $schedule)
    {
        // Admin boleh manage semua, user hanya boleh manage miliknya sendiri
        return $user->is_admin || $user->id === $schedule->user_id;
    }
}
