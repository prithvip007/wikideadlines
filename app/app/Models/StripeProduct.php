<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeProduct extends Model
{
    static public function getSearchProduct(): self {
        return StripeProduct::where('name', 'search')->first();
    }
}
