<?php

namespace App\Models\Snapshots;

use Carbon\Carbon;

/**
 * Class HolidaySnapshot
 * @package App\Models\Calculation\Snapshots
 *
 * @property int $id
 * @property string $name
 * @property Carbon $date
 */
class HolidaySnapshot extends Snapshot
{
    public function check(Carbon $date): bool
    {
        return $this->date->isSameDay($date);
    }

    public function getDateProperty(): Carbon
    {
        return Carbon::parse($this->data['date']);
    }
}
