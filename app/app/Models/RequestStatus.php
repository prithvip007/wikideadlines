<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * @package App\Models
 *
 * @property string $type
 * @property array $data
 */
class RequestStatus extends Model
{
    protected $table = 'requests_status';

    public function isApproved(): bool
    {
        return $this->id === 1;
    }
}
