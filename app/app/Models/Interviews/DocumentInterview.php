<?php

namespace App\Models\Interviews;

use App\Models\Interviews\Interview;
use App\Models\Calculation\Calculation;
use Exception;

class DocumentInterview extends Interview
{
    public function __construct()
    {
        parent::__construct('document.json');
    }

    // TODO: refactor
    private function fill(
        array $data,
        array $deliveryMethods
    ) {
        $questions = $this->getArray();

        foreach ($questions as &$question) {
            $varName = isset($question['key']) ? array_reduce(explode('-', $question['key']), function ($carry, $item) {
                if ($carry === null) {
                    return strtolower($item);
                }
            
                return $carry . ucfirst(strtolower($item));
            }) : '';

            switch ($question['type']) {
                case 'input-text':
                case 'textarea':
                    $question['data']['defaultValue'] = $data[$varName] ?? '';
                    break;
                case 'input-checkbox':
                    foreach ($question['data']['items'] as &$methodItem) {
                        $methodItem['defaultChecked'] = in_array($methodItem['id'], $deliveryMethods);
                    }
                    break;
                case 'input-radio':
                case 'select':
                    $item = null;

                    if (isset($data[$varName])) {
                        $item = $this->getItemById($question, $data[$varName]);
                    }

                    $question['data']['defaultValue'] = $item ? $item['title'] : '';
                    break;
            }
        }

        return $questions;
    }

    public function getFilledFromCalculation(Calculation $calculation) {
        $data = [
            'documentTitle' => $calculation->getSnapshotInstance()->document_type->name,
            'shortDescription' => $calculation->getSnapshotInstance()->document_type->small_description,
            'keywords' => $calculation->getSnapshotInstance()->document_type->keywords,
            'bestPractices' => $calculation->getSnapshotInstance()->document_type->best_practices,
        ];

        $deliveryMethods = [];

        if ( $calculation->document_type()->first()) {
            $deliveryMethods = $calculation->document_type()->first()->deliveryMethods()->get()->map(function ($deliveryMethod) {
                return $deliveryMethod->id;
            })->toArray();
        }

        return $this->fill($data, $deliveryMethods);
    }
}
