<?php

namespace App\Models\Snapshots;

use Carbon\Carbon;

/**
 * Class StateSnapshot
 * @package App\Models\Calculation\Snapshots
 *
 * @property int $id
 * @property string $name
 * @property string $timezone
 */
class StateSnapshot extends Snapshot
{
    /**
     * @var array
     */
    protected $holidays = [];

    /**
     * @var array
     */
    protected $dynamicHolidays = [];

    public function setHolidays(array $holidays): void
    {
        $this->holidays = $holidays;
    }

    /**
     * @var array
     */
    public function setDynamicHolidays(array $dynamicHolidays): void
    {
        $this->dynamicHolidays = $dynamicHolidays;
    }

    public function isBusinessDay(Carbon $date, bool $skipHolidays = false): bool
    {
        return  $skipHolidays
            ? !$this->isWeekend($date)
            : !$this->isHoliday($date) && !$this->isWeekend($date);
    }

    public function isWeekend(Carbon $date): bool
    {
        $copy = $date->copy();
        $copy->setTimezone($this->timezone);

        return $copy->isSunday() || $copy->isSaturday();
    }

    public function isHoliday(Carbon $date): bool
    {
        $copy = $date->copy();
        $copy->setTimezone($this->timezone);

        foreach ($this->holidays as $holiday) {
            if ($holiday->check($copy)) {
                return true;
            }
        }

        foreach ($this->dynamicHolidays as $dynamicHoliday) {
            if ($dynamicHoliday->isSameDay($copy)) {
                return true;
            }
        }

        return false;
    }
}
