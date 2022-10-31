<?php

namespace App\Models;

use App\Models\Snapshots\SnapshotableModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class State
 * @package App\Models
 *
 * @property string $name
 * @property Holiday[] $holidays
 * @property string $timezone
 * @property boolean $preselected
 *
 * @method static self create(array $attributes)
 * @method static \Illuminate\Database\Eloquent\Collection|self[] all()
 * @method static self findOrFail(mixed $id, array $columns = ['*'])
 */
class State extends SnapshotableModel
{
    use SoftDeletes;

    protected $with = [
        'holidays',
        'dynamicHolidays',
    ];

    protected $casts = [
        'preselected' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'holidays',
        'dynamicHolidays',
    ];

    public function dynamicHolidays()
    {
        return $this->hasMany(DynamicHoliday::class)->without('state');
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class)->without('state');
    }
}
