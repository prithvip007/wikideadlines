<?php

namespace App\Models\Calculation;

use App\Models\Calculation\Snapshots\DeadlineSnapshot;
use App\Models\DeliveryMethod;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DateAnswer;
use App\Models\User;
use App\Models\County;
use App\Models\DocumentType;
use App\Models\EarliestHearingDate;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Calculation
 * @package App\Models
 *
 * @property string|null $case_name
 * @property string $key
 * @property array|null $snapshot
 * @property Deadline[] $deadlines
 * @property int|null $delivery_area
 * @property Carbon|null $hd
 * @property Carbon|null $dps
 * @property Carbon|null $fcd
 * @property Carbon|null $decr
 * @property Carbon|null $doorjsbc
 * @property Carbon|null $td
 * @property Carbon|null $dnmbc
 * @property Carbon|null $afhd
 * @property Carbon|null $dsococcic
 * @property Carbon|null $daafwcoc
 * @property Carbon|null $dlpr
 * @property Carbon|null $dfaop
 * @property Carbon|null $dcf Date Complaint Filed
 * @property Carbon|null $ftds
 * @property Carbon|null $email
 * @property Carbon|null $regular_mail_within_state
 * @property Carbon|null $regular_mail_outside_state
 * @property Carbon|null $regular_mail_outside_country
 * @property string $hearing_courtroom
 * @property bool $same_judge
 * @property State $state
 * @property DeliveryMethod|null $delivery_method
 * @property DocumentType $document_type
 * @property string $hearing_courthouse
 */
class Calculation extends Model
{
    static $defaultCaseName = 'No case name';

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $dateTimeItems = array_merge(self::$events, self::$deliveryEvents);

        foreach ($dateTimeItems as $item) {
            $this->casts[$item] = 'datetime';
        }
    }


    use SoftDeletes;

    static $archivedEvents = ['dsococcic'];

    static $events = [
        'fcd',
        'dsococcic',
        'daafwcoc',
        'dps',
        'lad',
        'dd',
        'cymad',
        'monoeojd',
        'dcdr',
        'dfcmch',
        'dsnejk',
        'dmc',
        'dlpr',
        'ddsc',
        'dcc',
        'dds',
        'dmocs',
        'drc',
        'je',
        'opa',
        'exph',
        'dod',
        'tasd',
        'hd',
        'decr',
        'ftds',
        'td',
        'tdreq',
        'dfaop',
        'doorjsbc',
        'dnmbc',
        'afhd',
        'dcf',
        'daf',
        'ddpodot',
        'fsc'
    ];

    static function getActiveEvents() {
        return array_filter(self::$events, function($event) {
            return in_array($event, self::$archivedEvents) === false;
        });
    }

    static function getLocalesForActiveEvents() {
        return array_filter(__('events'), function($event) {
            return in_array($event, self::$archivedEvents) === false;
        }, ARRAY_FILTER_USE_KEY);
    }

    static $deliveryEvents = ['hand_delivery', 'email', 'electronic', 'regular_mail_within_state', 'regular_mail_outside_state', 'regular_mail_outside_country'];

    protected $casts = [
        'deadlines' => 'array',
        'snapshot' => 'array',
        'delivery_area' => 'integer',
        'same_judge' => 'boolean',
    ];

    /**
     * @var DataSnapshot
     */
    protected $_snapshot;

    /**
     * @var Deadline[]
     */
    protected $_deadlines;

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function delivery_method()
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function dateAnswers(): HasMany
    {
        return $this->hasMany(DateAnswer::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function earliestHearingDates(): HasMany {
        return $this->hasMany(EarliestHearingDate::class);
    }

    public function createSnapshot(): DataSnapshot
    {
        $this->_snapshot = DataSnapshot::create($this);
        $this->snapshot = $this->_snapshot->toArray();

        return $this->_snapshot;
    }

    public function getSnapshotInstance(): ?DataSnapshot
    {
        if(!$this->_snapshot && $this->snapshot) {
            $this->_snapshot = DataSnapshot::create($this);
        }

        return $this->_snapshot;
    }

    public function getDeadlinesAttribute()
    {
        if (!$this->_deadlines) {
            $this->_deadlines = [];
            $deadlines = json_decode($this->attributes['deadlines'], true);

            foreach ($deadlines as $deadline) {
                $this->_deadlines[] = Deadline::createFromArray($deadline, $this);
            }
        }

        return $this->_deadlines;
    }

    public function save(array $options = [])
    {
        if (!$this->exists) {
            $this->key = \Str::random(10);

            if(!$this->getSnapshotInstance()) {
                $this->createSnapshot();
            }
        }

        return parent::save($options);
    }

    public function calculate(string $type = 'document_received')
    {
        if (in_array($type, ['document_received', 'document_to_send']) === false) {
            throw new \Exception('Type must be document_received or document_to_send');
        }

        if(!$this->getSnapshotInstance()) {
            $this->createSnapshot();
        }

        $deadlines = [];

        foreach ($this->getSnapshotInstance()->deadlines as $deadline_snapshot) {

            /**
             * In "document_to_send" mode deadlines are optional
             * If a value for a deadlines isn't set, there is no need to calculate it
             */
            if (
                (
                    $type === 'document_to_send' ||
                    $deadline_snapshot->add_to === 'ftds' || 
                    $deadline_snapshot->add_to === 'td' ||
                    $deadline_snapshot->add_to === 'dps' 
                )
            ) {
                $isValueSet = isset($this->{$deadline_snapshot->add_to});

                if (!$isValueSet) {
                    continue;
                }
            }

            if (
                $type === 'document_received' &&
                in_array($deadline_snapshot->add_to, self::$deliveryEvents)
            ) {
                continue;
            }

            try {
                if (!$deadline_snapshot->calculate_if_same_judge || ($deadline_snapshot->calculate_if_same_judge && $this->same_judge)) {
                    $deadlines[] = Deadline::calculate($deadline_snapshot, $this)->toArray();
                }
            } catch (\Exception $exception) {
                if(config('app.debug')) {
                    throw $exception;
                } else {
                    \Log::error('Deadline (' . $deadline_snapshot->id . ') calculation failed', compact('exception'));
                }
            }
        }

        $this->attributes['deadlines'] = json_encode($deadlines);
    }

    static function findByKeyOrFail(string $key): self
    {
        return static::where('key', $key)->firstOrFail();
    }

    static function findByKey(string $key): self
    {
        return static::where('key', $key)->first();
    }

    public function isDPSLate(Deadline $deadline): bool
    {
        if (
            !$deadline->snapshot->check_dps_preciseness ||
            $this->dps === null
        ) {
            return false;
        }

        $timezone = $this->state->timezone;
        $dps = $this->dps->copy()->setTImezone($timezone);
        $date = $deadline->date->copy()->setTImezone($timezone);

        $dps->hour = 0;
        $dps->minute = 0;

        if ($dps->lte($date)) {
            return false;
        }

        return true;
    }

    public function getOverdueType(): int
    {
        $deadlines = $this->getDeadlinesAttribute();

        foreach ($deadlines as $deadline) {
            if ($deadline->checkDpsPreciseness() && $this->isDPSLate($deadline)) {
                return 1; 
            }
        }

        $nextDealineDate = $this->getNextDealineDate();

        if ($nextDealineDate === null) {
            return 2;
        }

        return 0;
    }

    public function getNextDealineDate(): ?\DateTime
    {
        $deadlines = $this->getDeadlinesAttribute();

        foreach ($deadlines as $deadline) {
            if ($deadline->checkDpsPreciseness() && $this->isDPSLate($deadline)) {
                continue;
            }

            if ($deadline->date->isPast()) {
                continue;
            }

            return $deadline->date;
        }

        return null;
    }

    public function getCaseNameAttribute($value)
    {
        return $value === null ? static::$defaultCaseName : $value;
    }
}
