<?php

namespace App\Models;

use App\Models\Snapshots\SnapshotableModel;
use Carbon\Carbon;

class DynamicHoliday extends SnapshotableModel
{
    public function state()
    {
        return $this->belongsTo(State::class)->without('dynamic_holidays');
    }
}
