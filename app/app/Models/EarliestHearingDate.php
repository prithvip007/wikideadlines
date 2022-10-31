<?php

namespace App\Models;

use App\Models\Calculation\Date;
use App\Models\DeliveryMethod;
use App\Models\Calculation\Calculation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EarliestHearingDate extends Model
{
    public function calculate()
    {
        $calculation = $this->calculation()->get()->first();
        $deliveryMethod = $this->deliveryMethod()->get()->first();
        $documentType = $calculation->document_type()->get()->first();
        $stateSnapshot = $calculation->getSnapshotInstance()->state;

        $date = new Date(new Carbon(), $stateSnapshot);

        if ($documentType->days_before_hd_court !== null) {
            $date->addCourtDays($documentType->days_before_hd_court * -1);
        } else {
            $date->addCalendarDays($documentType->days_before_hd_calendar * -1, false);
        }


        // Then we add deadline days to the base date
        if ($deliveryMethod->days !== 0) {
            $date->addCalendarDays($deliveryMethod->days * -1, false);
        }

        $this->value = $date->getCarbonInstance();
    }

    public function getValueAttribute($value)
    {

        return new Carbon($value);
    }

    public function deliveryMethod(): BelongsTo {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function calculation(): BelongsTo {
        return $this->belongsTo(Calculation::class);
    }
}
