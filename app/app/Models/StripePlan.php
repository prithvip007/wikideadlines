<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripePlan extends Model
{
    public function getDescriptionsAttribute($value)
    {
        $newValue = preg_replace('/}/', ']', $value);
        $newValue = preg_replace('/{/', '[', $newValue);

        return $newValue;
    }

    public function setDescriptionsAttribute($value)
    {
        $newValue = json_encode($value);
        $newValue = preg_replace('/\]/', '}', $newValue);
        $newValue = preg_replace('/\[/', '{', $newValue);

        $this->attributes['descriptions'] = $newValue;
    }
}
