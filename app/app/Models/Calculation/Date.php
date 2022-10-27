<?php

namespace App\Models\Calculation;

use App\Models\Snapshots\StateSnapshot;
use Carbon\Carbon;

class Date
{
    /**
     * @var Carbon
     */
    protected $date;

    /**
     * @var StateSnapshot
     */
    protected $state;

    public function __construct(Carbon $date, StateSnapshot $state)
    {
        $this->date = $date;
        $this->state = $state;
    }

    public function addCourtDays(int $days): self
    {
        $day = $days / abs($days);

        for ($i = abs($days); $i > 0; $i--) {
            $this->date->addDays($day);

            while (!$this->state->isBusinessDay($this->date)) {
                $this->date->addDays($day);
            }
        }

        return $this;
    }

    public function addCalendarDays(int $days, bool $skipBusinessDays = true): self
    {
        $day = $days / abs($days);

        $this->date->addDays($days);

        if ($skipBusinessDays) {
            $this->skipBusinessDays($day < -1);
        }

        return $this;
    }

    public function skipBusinessDays(bool $negative) {
        while (!$this->state->isBusinessDay($this->date, true)) {
            $this->date->addDays($negative ? -1 : 1);
        }
    }

    public function addBusinessDays(int $days): self
    {
        $this->date->addDays($days);

        while (!$this->state->isBusinessDay($this->date)) {
            $this->date->addDays(1);
        }

        return $this;
    }

    public function getCarbonInstance(): Carbon {
        return $this->date;
    }
}
