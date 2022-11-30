<?php

namespace App\Models\Calculation;

use App\Models\DeliveryMethod;
use App\Models\Snapshots\DeadlineSnapshot;
use App\Models\Snapshots\DeliveryMethodSnapshot;
use App\Models\Snapshots\DocumentTypeSnapshot;
use App\Models\Snapshots\HolidaySnapshot;
use App\Models\Snapshots\DynamicHolidaySnapshot;
use App\Models\Snapshots\StateSnapshot;

class DataSnapshot
{
    /**
     * @var StateSnapshot
     */
    public $state;


    public $documentDeliveryMethods = [];

    /**
     * @var HolidaySnapshot[]
     */
    public $holidays = [];

    /**
     * @var DynamicHolidaySnapshot[]
     */
    public $dynamicHolidays = [];


    /**
     * @var DocumentTypeSnapshot
     */
    public $document_type;

    /**
     * @var DeadlineSnapshot[]
     */
    public $deadlines = [];

    /**
     * @var DeliveryMethodSnapshot|null
     */
    public $delivery_method;

    /**
     * @var Calculation
     */
    public $calculation;

    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data, Calculation $calculation)
    {
        $this->data = $data;
        $this->state = new StateSnapshot($data['state']);
        $this->document_type = new DocumentTypeSnapshot($data['document_type']);
        $this->delivery_method = isset($data['delivery_method']) ? new DeliveryMethodSnapshot($data['delivery_method']) : null;
        $this->calculation = $calculation;
        $this->documentDeliveryMethods = $data['documentDeliveryMethods'] ?? null;

        foreach ($data['holidays'] as $holiday) {
            $this->holidays[] = new HolidaySnapshot($holiday);
        }

        if (isset($data['dynamicHolidays'])) {
            foreach ($data['dynamicHolidays'] as $dynamicHoliday) {
                $this->dynamicHolidays[] = new DynamicHolidaySnapshot($dynamicHoliday);
            }
        }

        foreach ($data['deadlines'] as $deadline) {
            $this->deadlines[] = new DeadlineSnapshot($deadline);
        }

        $this->state->setHolidays($this->holidays);
        $this->state->setDynamicHolidays($this->dynamicHolidays);
    }

    public function toArray(): array
    {
        return $this->data;
    }

    static public function create(Calculation $calculation): DataSnapshot
    {
        if ($calculation->snapshot) {
            return new static($calculation->snapshot, $calculation);
        }

        $holidays = [];
        $dynamicHolidays = [];

        foreach ($calculation->state->holidays as $holiday) {
            $holidays[] = HolidaySnapshot::create($holiday);
        }

        foreach ($calculation->state->dynamicHolidays as $dynamicHoliday) {
            $dynamicHolidays[] = DynamicHolidaySnapshot::create($dynamicHoliday);
        }

        $state = StateSnapshot::create($calculation->state);

        $holidays = array_map(function ($holiday) {
            return $holiday->toArray();
        }, $holidays);

        $dynamicHolidays = array_map(function ($dynamicHoliday) {
            return $dynamicHoliday->toArray();
        }, $dynamicHolidays);

        $snapshot = [
            'state' => $state->toArray(),
            'holidays' => $holidays,
            'documentDeliveryMethods' => $calculation->document_type()->first()->deliveryMethods()->get(),
            'dynamicHolidays' => $dynamicHolidays,
            'document_type' => DocumentTypeSnapshot::create($calculation->document_type)->toArray(),
            'deadlines' => [],
            'delivery_method' => $calculation->delivery_method ? DeliveryMethodSnapshot::create($calculation->delivery_method)->toArray() : null
        ];

        foreach ($calculation->document_type->deadlines as $deadline) {
            $snapshot['deadlines'][] = DeadlineSnapshot::create($deadline)->toArray();
        }

        $calculation->snapshot = $snapshot;

        return new static($snapshot, $calculation);
    }

    public function getDeadlineById(int $id): ?DeadlineSnapshot
    {
        foreach ($this->deadlines as $deadline) {
            if ($deadline->id === $id) {
                return $deadline;
            }
        }

        return null;
    }
}

