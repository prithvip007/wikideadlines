<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DateQuestion;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DateAnswer extends Model
{
    public function dateQuestion(): BelongsTo
    {
        return $this->belongsTo(DateQuestion::class);
    }

    public function getValueAttribute($value)
    {
        return new Carbon($value);
    }

    protected $fillable = [
        'value',
        'date_question_id',
        'calculation_id'
    ];
}
