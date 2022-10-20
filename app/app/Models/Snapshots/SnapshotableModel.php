<?php

namespace App\Models\Snapshots;

use Illuminate\Database\Eloquent\Model;

abstract class SnapshotableModel extends Model implements Snapshotable
{
    public function snapshot(): array
    {
        $hidden = $this->hidden;
        $this->hidden = [];

        $array = $this->attributesToArray();

        $this->hidden = $hidden;

        return $array;
    }
}
