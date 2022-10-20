<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class InvestorApplication extends Model
{
    static $applicationDelayDays = 0;

    static public function getDifferenceWithCurrentDateInDays(Carbon $date): int
    {
        $nowMidnight = Carbon::createMidnightDate();

        $targetMidnight = Carbon::createMidnightDate($date->year, $date->month, $date->day);

        $days = $targetMidnight->diffInDays($nowMidnight);

        return $days;
    }

    static private function getDaysSinceLastApplicationForUser(User $user): ?int
    {
        $application = self::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(1)
            ->first();
        
        if ($application === null) {
            return null;
        }

        return self::getDifferenceWithCurrentDateInDays($application->created_at);
    }

    static public function canUserApply(User $user)
    {
        $days = self::getDaysSinceLastApplicationForUser($user);

        if ($days === null) {
            return true;
        }

        if ($days >= self::$applicationDelayDays) {
            return true;
        }

        return false;
    }

    static public function getLeftDelayDaysForUser(User $user): int
    {
        $days = self::getDaysSinceLastApplicationForUser($user);

        if ($days === null) {
            return 0;
        }

        if ($days >= self::$applicationDelayDays) {
            return 0;
        }

        return  self::$applicationDelayDays - $days;
    }
}
