<?php

namespace App\Models\Interviews;

use App\Models\Interviews\Interview;

class JurisdictionInterview extends Interview
{
    public function __construct()
    {
        parent::__construct('jurisdiction.json');
    }
}
