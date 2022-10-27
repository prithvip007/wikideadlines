<?php

namespace App\Models\Calculation;

use App\Models\Snapshots\DeadlineSnapshot;
use Carbon\Carbon;

class Deadline
{
    /**
     * @var DeadlineSnapshot
     */
    public $snapshot;

    /**
     * @var Carbon
     */
    public $date;


    public function __construct(DeadlineSnapshot $snapshot, Carbon $date)
    {
        $this->snapshot = $snapshot;
        $this->date = $date;
    }

    public function checkDpsPreciseness(): bool
    {
        return $this->snapshot->check_dps_preciseness;
    }

    public function toArray(): array
    {
        return [
            'snapshot_id' => $this->snapshot->id,
            'date' => $this->date
        ];
    }

    static protected function addDays(Date $date, int $days, string $days_type)
    {
        switch ($days_type) {
            case 'court':
                $date->addCourtDays($days);
                break;
            case 'next_business_day':
                $date->addBusinessDays($days);
                break;
            case 'calendar':
                $date->addCalendarDays($days, false);
                break;
            default:
                throw new \Exception('Unknown `days_type` value: ' . $days_type);
        }
    }

    static public function calculate(DeadlineSnapshot $deadline, Calculation $calculation): self
    {
        $snapshot = $calculation->getSnapshotInstance();

        $sign = $deadline->days < 0 ? -1 : 1;

        if (in_array($deadline->add_to, Calculation::$deliveryEvents)) {
            $date = new Date($calculation->{$deadline->add_to}->copy(), $snapshot->state);

            // Details
            // https://app.asana.com/0/1172056509697226/1202045469529179
            static::addDays($date, -16, 'court');

            // Then we add deadline days to the base date
            if ($deadline->days !== 0) {
                static::addDays($date, $deadline->days, $deadline->days_type);
            }
        } else {
            if (in_array($deadline->add_to, Calculation::getActiveEvents())) {
                $date = new Date($calculation->{$deadline->add_to}->copy(), $snapshot->state);
            } else {
                throw new \Exception('Unknown value of `add_to` attribute:' . $deadline->add_to);
            }
            // Then we add deadline days to the base date
            if ($deadline->days !== 0) {
                static::addDays($date, $deadline->days, $deadline->days_type);
            }

            if ($snapshot->delivery_method && $deadline->subtract_delivery_days)  {

                // If a document was sent outside the country, we add more days
                if ($calculation->delivery_area === 1 && $snapshot->delivery_method->has_outside_country_days) {
                    static::addDays($date, $snapshot->delivery_method->outside_country_days * $sign, 'calendar');
                } else if ($calculation->delivery_area === 2 && $snapshot->delivery_method->has_outside_state_days) {
                    static::addDays($date, $snapshot->delivery_method->outside_state_days * $sign, 'calendar');
                } else if ($snapshot->delivery_method->days !== 0) {
                    static::addDays($date, $snapshot->delivery_method->days * $sign, $snapshot->delivery_method->days_type);
                }

            }
        }

        // here we adjust calendar days so it won't fall on a business days
        $date->skipBusinessDays($sign === -1);

        return new static($deadline, $date->getCarbonInstance());
    }

    static public function createFromArray(array $deadline, Calculation $calculation): self
    {
        $snapshot = $calculation->getSnapshotInstance()->getDeadlineById($deadline['snapshot_id']);
        $date = Carbon::parse($deadline['date']);

        return new static($snapshot, $date);
    }
}
