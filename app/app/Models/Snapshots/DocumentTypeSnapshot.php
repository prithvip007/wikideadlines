<?php

namespace App\Models\Snapshots;

/**
 * Class DocumentTypeSnapshot
 * @package App\Models\Calculation\Snapshots
 *
 * @property int $id
 * @property string $name
 */
class DocumentTypeSnapshot extends Snapshot
{

    function getBestPracticesProperty() {
        $property = 'best_practices';

        if (isset($this->data[$property])) {
            return $this->data[$property];
        }

        return null;
    }
}
