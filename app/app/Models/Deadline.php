<?php

namespace App\Models;

use App\Models\Snapshots\SnapshotableModel;
use App\Models\DeadlineThumb;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Calculation\Calculation;
use App\Events\DeadlineCreated;

/**
 * Class Deadline
 * @package App\Models
 *
 * @property DocumentType $group
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
 * @property string $add_to
 * @property bool $subtract_delivery_days
 * @property bool $requires_delivery_method
 * @property bool $requires_fcd
 * @property bool $requires_decr
 * @property bool $requires_td
 * @property bool $requires_ftds
 * @property bool $requires_dnmbc
 * @property bool $requires_afhd
 * @property bool $requires_doorjsbc
 * @property bool $requires_dsococcic
 * @property bool $requires_daafwcoc
 * @property bool $requires_dlpr
 * @property bool $requires_dfaop
 * @property bool $requires_dcf
 * @property bool $check_dps_preciseness
 * @property bool $calculate_if_same_judge
 * 
 *
 */
class Deadline extends SnapshotableModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'days',
        'days_type',
        'add_to',
        'document_type_id',
        'title'
    ];

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

    protected $casts = [
        'subtract_delivery_days' => 'bool',
        'visibility_scopes' => 'array',
        'check_dps_preciseness' => 'bool',
        'calculate_if_same_judge' => 'bool',
    ];

    protected $appends = ['requires_delivery_method'];

    protected $dispatchesEvents = [
        'saved' => DeadlineCreated::class
    ];

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

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class)->without('deadlines');
    }

    public function deadlineThumbs()
    {
        return $this->hasMany(DeadlineThumb::class);
    }
    
    private function isTriggeringEventRequired(string $event)
    {
        return $this->add_to === $event && in_array($event, Calculation::getActiveEvents());
    }

    protected function getRequiresDeliveryMethodAttribute(): bool
    {
        return $this->subtract_delivery_days;
    }

    protected function getRequiresDpsAttribute(): bool
    {
        return in_array($this->add_to, ['dps']) || $this->check_dps_preciseness;
    }

    static public function createStandardMotionDeadlines(int $document_type_id)
    {
        $standardMotionDeadlines = [
            [
                'name' => 'L/D to serve any opposition to the motion is 8 court days prior to the hearing date. Service must be such that the opposing party receives the opposition within 1 business day after its filing with the Court.  (Code of Civil Procedure §1005(c))',
                'days' => -9,
                'days_type' => 'court',
                'add_to' => 'hd',
                'title' => 'Serve Opposition'
            ],
            [
                'name' => 'Hearing Date for the motion.',
                'days' => 0,
                'days_type' => 'calendar',
                'add_to' => 'hd',
                'title' => 'Hearing Date'
            ],
            [
                'name' => 'L/D to file motion with the Court is 16 Court days prior to the hearing date.  (Code of Civil Procedure §1005(b))',
                'days' => -16,
                'days_type' => 'court',
                'add_to' => 'hd',
                'title' => 'L/D to file motion'
            ],
            [
                'name' => 'L/D to file any opposition to the motion is 9 court days prior to the hearing date.  L/D to file motion with the Court is 16 Court days prior to the hearing date.  (Code of Civil Procedure §1005(b))',
                'days' => -9,
                'days_type' => 'court',
                'add_to' => 'hd',
                'title' => 'Opposition'
            ],
            [
                'name' => 'L/D to file any Reply to the motion 5 court days prior to the hearing date.  L/D to file motion with the Court is 16 Court days prior to the hearing date.  (Code of Civil Procedure §1005(b))',
                'days' => -5,
                'days_type' => 'court',
                'add_to' => 'hd',
                'title' => 'Reply'
            ],
            [
                'name' => 'L/D to serve any Reply to the motion is 5 court days prior to the hearing date, and service must be such that the opposing party receives the opposition within 1 business day after its filing.  L/D to file motion with the Court is 16 Court days prior to the hearing date.  (Code of Civil Procedure §1005(c))',
                'days' => -5,
                'days_type' => 'court',
                'add_to' => 'hd',
                'title' => 'Serve Reply'
            ],
            [
                'name' => 'L/D to serve motion on the opposing parties is 16 court days prior to the hearing minus the number of days under Code of Civil Procedure §1005(b) added for service.',
                'days' => -16,
                'days_type' => 'court',
                'add_to' => 'hd',
                'title' => 'L/D to serve motion'
            ]
        ];

        foreach ($standardMotionDeadlines as $deadline) {
            Deadline::create(array_merge($deadline, [ 'document_type_id' => $document_type_id ]));
        }
    }
}
