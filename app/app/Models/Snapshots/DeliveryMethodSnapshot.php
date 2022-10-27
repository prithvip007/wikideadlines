<?php

namespace App\Models\Snapshots;

/**
 * Class DeliveryMethodSnapshot
 * @package App\Models\Calculation\Snapshots
 *
 * @property int $id
 * @property string $name
 * @property int $days
 * @property string $days_type
 * @property int|null $outside_state_days
 * @property int|null $outside_country_days
 * @property bool $has_outside_state_days
 * @property bool $has_outside_country_days
 */
class DeliveryMethodSnapshot extends Snapshot
{
    function getReferenceKeyProperty() {
        $property = 'reference_key';

        if (isset($this->data[$property])) {
            return $this->data[$property];
        }

        return null;
    }
}
