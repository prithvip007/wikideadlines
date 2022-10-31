<?php

namespace App\Models\Snapshots;

/**
 * Class DeadlineSnapshot
 * @package App\Models\Calculation\Snapshots
 *
 * @property int $id
 * @property string $name
 * @property int $days
 * @property string $days_type
 * @property string $add_to
 * @property bool $subtract_delivery_days
 * @property bool $check_dps_preciseness
 * @property bool $calculate_if_same_judge
 * @property bool $best_practices
 */
class DeadlineSnapshot extends Snapshot
{
    function getBestPracticesProperty() {
        $property = 'best_practices';

        if (isset($this->data[$property])) {
            return $this->data[$property];
        }

        return null;
    }

    function getTitleProperty() {
        $property = 'title';

        if (isset($this->data[$property])) {
            return $this->data[$property];
        }

        return null;
    }

    function getVisibilityScopesProperty() {
        $property = 'visibility_scopes';

        if (isset($this->data[$property])) {
            return $this->data[$property];
        }

        return [];
    }
}
