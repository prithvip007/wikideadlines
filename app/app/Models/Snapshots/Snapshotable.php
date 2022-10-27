<?php

namespace App\Models\Snapshots;

interface Snapshotable
{
    public function snapshot(): array;
}
