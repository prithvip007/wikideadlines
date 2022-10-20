<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DateAnswer;
use App\Models\DateQuestionType;

class DateQuestion extends Model
{
    public function dateAnswers(): HasMany
    {
        return $this->hasMany(DateAnswer::class);
    }

    public function dateQuestionType(): BelongsTo
    {
        return $this->belongsTo(DateQuestionType::class);
    }
}
