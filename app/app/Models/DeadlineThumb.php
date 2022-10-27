<?php

namespace App\Models;

use App\Models\Calculation\Calculation;
use Illuminate\Database\Eloquent\Model;

class DeadlineThumb extends Model
{
    static public function getHistoricalCount(int $deadlineId, int $calculationId): int {
        $calculation = Calculation::find($calculationId);

        if (!$calculation) {
            throw new \Exception('Calculation doesn\'t exist');
        }

        // select a deadline version which was effective at calculation time
        $deadline = \DB::table(
            \DB::raw("
                (
                    SELECT id, updated_at as started_at, now() as ended_at, 'live' as source FROM deadlines 
                    UNION all
                    SELECT id, started_at, ended_at, 'audit' as source FROM deadlines_audit
                ) deadlines
            ")
        )->whereRaw(
            'started_at <= ? AND ended_at > ? AND id = ?',
            [$calculation->created_at, $calculation->created_at, $deadlineId]
        )->first();

        // when this feature was added, some deadlines already didn't exists in the database
        // so we just return 0 for them
        if (!$deadline) {
            return 0;
        }

        // count all thumbs up for an effective dealine
        $count = \DB::table('deadline_thumbs')
            ->join('calculations', 'deadline_thumbs.calculation_id', '=', 'calculations.id')
            ->whereRaw(
                'calculations.created_at >= ? AND calculations.created_at < ? AND deadline_id = ?',
                [$deadline->started_at, $deadline->ended_at, $deadlineId]
            )
            ->count();

        return $count;
    }
}
