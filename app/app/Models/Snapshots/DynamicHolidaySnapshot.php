<?php

namespace App\Models\Snapshots;

use Carbon\Carbon;

/**
 * Class DynamicHolidaySnapshot
 * @package App\Models\Calculation\Snapshots
 */
class DynamicHolidaySnapshot extends Snapshot
{
    public function calculate(int $year): Carbon
    {
        $week_day = (int) $this->week_day;
        $order = (int) $this->order;
        $month = (int) $this->month;

        $dt = new Carbon();

        $dt->year = $year;
        $dt->month = $month;

        // calculating as the last day in a month
        if ($order === 0) {
            $dt->endOfMonth();

            // as we use endOfMonth() we should check whether week_day exists in the last week of the month
            if ($dt->dayOfWeek < $week_day) {
                $dt->addWeeks(-1);
            }

            $dt->weekday($week_day);

            return $dt;
        }

        $dt->startOfMonth();

        // as we use startOfMonth() we should check whether week_day exists in the first week of the month
        if ($dt->dayOfWeek > $week_day) {
            $dt->addWeeks(1);
        }

        $dt->weekday($week_day);

        // weekOfMonth is calculated as monthDays/7 so it's ok to substract it from order
        // i.e. a month starts from friday, for the next 7 days weekOfMonth is still 1
        $dt->addWeeks($order - $dt->weekOfMonth);

        return $dt;
    }

    public function isSameDay(Carbon $date)
    {
       return $this->calculate($date->year)->isSameDay($date);
    }
}
