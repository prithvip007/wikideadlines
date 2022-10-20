<?php

namespace App\Models;

use App\Models\Snapshots\SnapshotableModel;
use Carbon\Carbon;

/**
 * Class Holiday
 * @package App\Models
 *
 * @property State $state
 * @property string $date
 */
class Holiday extends SnapshotableModel
{
    public function state()
    {
        return $this->belongsTo(State::class)->without('holidays');
    }
}
