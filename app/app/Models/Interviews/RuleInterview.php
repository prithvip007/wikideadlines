<?php

namespace App\Models\Interviews;

use File;
use App\Models\Interviews\Interview;
use App\Models\Calculation\Calculation;
use App\Models\DeliveryMethod;
use App\Models\Snapshots\DeadlineSnapshot;

use Exception;

class RuleInterview extends Interview
{
    protected $path;

    public function __construct()
    {
        parent::__construct('rule.json');
    }

    private function getItemByReferenceKey(array &$question, string $referenceKey) {
        foreach ($question['data']['items'] as &$item) {
            if (isset($item['referenceKey']) && $item['referenceKey'] === $referenceKey) {
                return $item;
            }
        }

        return null;
    }

    public function getFilledFromCalculation(Calculation $calculation, ?array $optionalKeys): array {
        $result = [];

        $deadlines = $calculation->getSnapshotInstance()->deadlines;

        foreach ($deadlines as $deadline) {
            $questions = $this->fill(
                $deadline->name,
                $deadline->subtract_delivery_days,
                $deadline->days_type,
                $deadline->best_practices,
                $deadline->days,
                $calculation->getSnapshotInstance()->document_type->name,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                $optionalKeys,
                $deadline->add_to,
                $deadline->title,
                $deadline->visibility_scopes ?? []
            );

            $result[$deadline->id] = $questions;
        }

        return $result;
    }

    public function getFilledFromDeadline(DeadlineSnapshot $deadline, string $documentName, ?array $optionalKeys) {
        return $this->fill(
            $deadline->name,
            $deadline->subtract_delivery_days,
            $deadline->days_type,
            $deadline->best_practices,
            $deadline->days,
            $documentName,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $optionalKeys,
            null,
            $deadline->title,
            []
        );
    }

    public function getFilledFromArray(array $deadline, string $documentName, ?array $optionalKeys)
    {
        return $this->fill(
            $deadline['name'],
            $deadline['requiresDeliveryMethod'],
            $deadline['daysType'],
            $deadline['bestPractices'],
            $deadline['days'],
            $documentName,
            $deadline['deliveryMethods'],
            $deadline['eventTime'],
            $deadline['acceptableMethodsLimit'],
            $deadline['deadlineRuleTitle'],
            $deadline['authoritySource'],
            $deadline['anotherDelvieryMethod'],
            $deadline['authorityLink'],
            $optionalKeys,
            null,
            null,
            []
        );
    }

    public function getFilledWithDocumentTypeName(string $name) {
        return $this->fill(null, null, null, null, null, $name, null, null, null, null, null, null, null, null, null, null, []);
    }

    private function fill(
        ?string $deadlineName,
        ?bool $requiresDeliveryMethod,
        ?string $daysType,
        ?string $bestPractices,
        ?int $days,
        ?string $documentName,
        ?array $deliveryMethods,
        ?int $eventTime,
        ?int $acceptableMethodsLimit,
        ?string $deadlineRuleTitle,
        ?string $authoritySource,
        ?string $anotherDelvieryMethod,
        ?string $authorityLink,
        ?array $optionalKeys,
        ?string $triggeringEvent,
        ?string $deadlineTitle,
        ?array $visibilityScopes
    ) {
        $questions = $this->getArray();

        if ($deliveryMethods === null) {
            $deliveryMethods = DeliveryMethod::all()->map(function ($deliveryMethod) {
                if (in_array($deliveryMethod->reference_key, ['certified_mail', 'personal_service', 'acknowledgement'])) {
                    return null;
                }

                return $deliveryMethod->reference_key;
            })->toArray();
        }

        if ($optionalKeys) {
            foreach ($questions as &$question) {
                if (in_array($question['key'], $optionalKeys)) {
                    $question['data']['required'] = false;
                }                
            }
        }

        try {        
            foreach ($questions as &$question) {
                switch ($question['key']) {
                    case 'document-title':
                        $question['data']['defaultValue'] = $documentName;
                        break;
                    case 'deadline-rule-title':
                        $question['data']['defaultValue'] = $deadlineTitle;
                        break;
                    case 'deadline-rule-description':
                        $question['data']['defaultValue'] = $deadlineName;
                        break;
                    case 'acceptable-methods-limit':
                        $item = $this->getItemById($question, $acceptableMethodsLimit === null ? 1 : $acceptableMethodsLimit);
                        $question['data']['defaultValue'] = $item ? $item['title'] : '';
                        break;
                    case 'delivery-methods-list':
                        foreach ($question['data']['items'] as &$methodItem) {
                            $methodItem['defaultChecked'] = in_array($methodItem['referenceKey'], $deliveryMethods);
                        }
                        break;
                    case 'add-days-delivery':
                        $item = $this->getItemById($question, $requiresDeliveryMethod ? 1 : 2);

                        $question['data']['defaultValue'] = $item ? $item['title'] : '';
                        break;
                    case 'day-types':
                        $item = null;

                        if ($daysType === 'calendar') {
                            $item = $this->getItemById($question, 2);
                        } elseif ($daysType === 'court') {
                            $item = $this->getItemById($question, 1);
                        }

                        $question['data']['defaultValue'] = $item ? $item['title'] : '';
                        break;
                    case 'event-time':
                        $item = null;

                        if ($eventTime !== null) {
                            $item = $this->getItemById($question, $eventTime);
                        } else if ($days !== null) {
                            $item = $this->getItemById($question, $days < 0 ? 1 : 2);
                        }

                        $question['data']['defaultValue'] = $item ? $item['title'] : '';
                        break;
                    case 'days-number-after':
                    case 'days-number-before':
                        $question['data']['defaultValue'] = abs($days);
                        break;
                    case 'best-practice':
                        $question['data']['defaultValue'] = $bestPractices;
                        break;
                    case 'visibility-scope':
                        foreach ($question['data']['items'] as &$scopeItem) {
                            $scopeItem['defaultChecked'] = in_array($scopeItem['referenceKey'], $visibilityScopes);
                        }
                        break;
                    case 'deadline-rule-title':
                        $question['data']['defaultValue'] =  (string) $deadlineRuleTitle;
                        break;
                    case 'authority-source':
                        $item = $authoritySource === null ? null : $this->getItemById($question, $authoritySource);

                        $question['data']['defaultValue'] = $item ? $item['title'] : '';
                        break;
                    case 'another-delviery-method':
                        $question['data']['defaultValue'] = (string) $anotherDelvieryMethod;
                        break;
                    case 'authority-link':
                        $question['data']['defaultValue'] = (string) $authorityLink;
                        break;
                    case 'triggering-event':

                        if ($triggeringEvent === null) {
                            break;
                        }

                        $item = $this->getItemByReferenceKey($question, $triggeringEvent);

                        $question['data']['defaultValue'] = $item ? $item['title'] : '';
                        break;
                }
            }
        } catch (Exception $e) {
            //
        }

        return $questions;
    }
}
