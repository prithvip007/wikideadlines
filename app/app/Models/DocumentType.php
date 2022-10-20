<?php

namespace App\Models;

use App\Models\Snapshots\SnapshotableModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Calculation\Calculation;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use phpDocumentor\Reflection\Types\Integer;

/**
 * Class DeadlineGroup
 * @package App\Models
 *
 * @property string $name
 * @property string $keywords
 * @property \Illuminate\Database\Eloquent\Collection|Deadline[] $deadlines
 * @property DeliveryMethod[] $delivery_methods
 * @property int[] $delivery_method_ids
 * @property bool $ask_hearing_courthouse
 * @property bool $ask_hearing_courtroom
 * @property bool $requires_hd
 * @property bool $requires_dps
 * @property bool $requires_lad
 * @property bool $requires_dd
 * @property bool $requires_cymad
 * @property bool $requires_monoeojd
 * @property bool $requires_dcdr
 * @property bool $requires_dfcmch
 * @property bool $requires_daf
 * @property bool $requires_ddpodot
 * @property bool $requires_fsc
 * @property bool $requires_dsnejk
 * @property bool $requires_dmc
 * @property bool $requires_ddsc
 * @property bool $requires_dcc
 * @property bool $requires_dds
 * @property bool $requires_dmocs
 * @property bool $requires_drc
 * @property bool $requires_je
 * @property bool $requires_opa
 * @property bool $requires_exph
 * @property bool $requires_dod
 * @property bool $requires_tasd
 * @property bool $requires_delivery_method
 * @property bool $requires_fcd
 * @property bool $requires_decr
 * @property bool $requires_td
 * @property bool $requires_tdreq
 * @property bool $requires_doorjsbc
 * @property bool $requires_daafwcoc
 * @property bool $requires_dlpr
 * @property bool $requires_ftds
 * @property bool $requires_dfaop
 * @property bool $requires_dnmbc
 * @property bool $requires_afhd
 * @property bool $requires_same_judge
 * @property bool $requires_dcf Date complaint filed
 * @property string|null $small_description
 *
 * @method static DocumentType create(array $attributes)
 * @method static self findOrFail(mixed $id, array $columns = ['*'])
 */
class DocumentType extends SnapshotableModel
{
    use SoftDeletes;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $events = array_merge(Calculation::$events, Calculation::$deliveryEvents);

        foreach ($events as $event) {
            array_push($this->appends, "requires_$event");
        }
    }

    public function __get($name)
    {
        $events = collect([Calculation::$events, Calculation::$deliveryEvents])->collapse();

        $index = $events->search(function ($value, $key) use ($name) {
            return "requires_$value" === $name;
        });

        $event = $events->get(is_int($index) ? $index : null);

        if (
            $event &&
            array_key_exists($name, $this->attributes) === false && 
            $this->hasGetMutator($name) === false
        ) {
            return $this->isTriggeringEventRequired($event);
        }

        return parent::__get($name);
    }

    public function __call($name, $value)
    {
        $events = collect([Calculation::$events, Calculation::$deliveryEvents])->collapse();

        $index = $events->search(function ($value, $key) use ($name) {
            return 'getRequires'.\Str::studly($value).'Attribute' === $name;
        });

        if ($index !== false) {
            $event = $events->get(is_int($index) ? $index : null);
            return $this->{"requires_$event"};
        }

        return parent::__call($name, $value);
    }

    protected $with = [
        'deadlines',
        'dateQuestions'
    ];

    protected $casts = [
        'ask_hearing_courtroom' => 'bool',
        'ask_hearing_courthouse' => 'bool'
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'deadlines'
    ];

    protected $appends = [
        'requires_delivery_method',
        'requires_same_judge',
    ];

    public function getDeliveryMethodIdsAttribute()
    {
        return $this->deliveryMethods->pluck('id')->toArray();
    }

    public function deliveryMethods(): BelongsToMany
    {
        return $this->belongsToMany(DeliveryMethod::class, 'document_type_delivery_method');
    }

    public function dateQuestions(): BelongsToMany
    {
        return $this->belongsToMany(DateQuestion::class)->withTimestamps();
    }

    public function deadlines(): HasMany
    {
        return $this->hasMany(Deadline::class)->without('document_type');
    }

    public function isMotion() {
        return $this->days_before_hd_court !== null || $this->days_before_hd_calendar !== null;
    }

    protected function getRequiresDeliveryMethodAttribute(): bool
    {
        return true;
    }

    private function isTriggeringEventRequired(string $event) {
        foreach ($this->deadlines as $deadline) {
            if ($deadline->{"requires_$event"}) {
                return true;
            }
        }

        return false;
    }

    protected function getRequiresSameJudgeAttribute(): bool
    {
        foreach ($this->deadlines as $deadline) {
            if ($deadline->calculate_if_same_judge) {
                return true;
            }
        }

        return false;
    }

    public function delete()
    {
        $this->deadlines()->delete();
        return parent::delete();
    } 
}
