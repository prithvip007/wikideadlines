<?php

namespace App\Models;

use App\Models\Snapshots\SnapshotableModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DeliveryMethod
 * @package App\Models
 *
 * @property string $name
 * @property string $unique_id
 * @property integer $days
 * @property string $days_type
 * @property integer|null $outside_state_days
 * @property integer|null $outside_country_days
 * @property bool $has_outside_state_days
 * @property bool $has_outside_country_days
 * @property bool $preselected
 *
 * @method static self findOrFail(mixed $id, array $columns = ['*'])
 */
class DeliveryMethod extends SnapshotableModel
{
    use SoftDeletes;

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    protected $casts = [
        'days' => 'integer',
        'outside_state_days' => 'integer',
        'outside_country_days' => 'integer',
        'preselected' => 'bool'
    ];

    protected $appends = [
        'has_outside_state_days',
        'has_outside_country_days'
    ];

    protected function getHasOutsideStateDaysAttribute()
    {
        return $this->outside_state_days !== null;
    }

    protected function getHasOutsideCountryDaysAttribute()
    {
        return $this->outside_country_days !== null;
    }
}
