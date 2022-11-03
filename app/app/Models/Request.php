<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestStatus;
use App\Models\Calculation\Calculation;
use App\Models\DeliveryMethod;
use Exception;

/**
 * Class Request
 * @package App\Models
 *
 * @property string $type
 * @property array $data
 */
class Request extends Model
{
    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'type',
        'data'
    ];

    private function getDataByKeys(array $keys): array {
        $results = [];

        foreach ($this->data['deadlines'] as $deadline) {
            if (in_array($deadline['meta']['key'], $keys)) {
                $results[$deadline['meta']['key']] = [
                    'value' => $deadline['value'],
                    'meta' => $deadline['meta']
                ];
            }
        }

        return $results;
    }

    public function status()
    {
        return $this->belongsTo(RequestStatus::class);
    }

    public function getFormattedType()
    {
        $map = [
            'edit_deadline' => 'edit',
            'add_deadline' => 'create',
            'document_type' => 'create',
            'edit_document_type' => 'edit'
        ];

        return isset($map[$this->type]) ? $map[$this->type] : $this->type;
    }

    public function mapToDocument(): array
    {
        if ((in_array($this->type, ['document_type', 'edit_document_type']) === false)) {
            throw new Exception('Type must be: document_type, edit_document_type');
        }

        $keys = ['document-title', 'short-description', 'keywords', 'delivery-methods-list', 'best-practices', 'standard-motion-briefing'];


        $data = $this->getDataByKeys($keys);

        $keywords = null;

        echo "<pre>";
        echo ("keys");
        print_r($key);
        echo ("data");
        print_r($data);




        if (isset($data['keywords'])) {
            $keywordsArray = preg_split('/\s+/', $data['keywords']['value']);
            echo ("keywords array");
            print_r($keywordsArray);

            if ($keywordsArray !== false) {
                $keywordsArray = array_unique($keywordsArray);
                $keywords = implode (", ", $keywordsArray);;
            }
        }

        $methods = [];

        if (isset($data['delivery-methods-list']['meta']['item']['referenceKeys'])) {
            $referenceKeys = $data['delivery-methods-list']['meta']['item']['referenceKeys'];

            $methods = DeliveryMethod::whereIn('reference_key', $referenceKeys)->get();
            echo ("keywords array");
            print_r($methods);
            die;
        }

        $includeStandardMotionDeadlines = false;
        if (isset($data['standard-motion-briefing']['meta']['item']['id'])) {
            $includeStandardMotionDeadlines = $data['standard-motion-briefing']['meta']['item']['id'] === 1;
        }

        return [
            'document' => [
                'name' => isset($data['document-title']) ? $data['document-title']['value'] : null,
                'small_description' => isset($data['short-description']) ? $data['short-description']['value'] : null,
                'keywords' => $keywords,
                'best_practices' => isset($data['best-practices']) ? $data['best-practices']['value'] : null,
            ],
            'standard_motion_briefing' => $includeStandardMotionDeadlines,
            'deliveryMethods' => $methods
        ];
    }

    public function mapToDeadline(): array
    {

        if (in_array($this->type, ['edit_deadline', 'add_deadline']) === false) {
            throw new Exception(in_array($this->type, ['edit_deadline', 'add_deadline']));
        }

        $keys = [
            'deadline-rule-description',
            'days-number-after',
            'days-number-before',
            'day-types',
            'best-practice',
            'triggering-event',
            'deadline-rule-title',
            'add-days-delivery',
            'visibility-scope'
        ];

        $scopes = [
            'no_display:document_received',
            'no_check:document_received',
            'no_display:document_to_send',
            'no_check:document_to_send'
        ];

        $data = $this->getDataByKeys($keys);

        $days = null;

        if (isset($data['days-number-after'])) {
            $days = $data['days-number-after']['value'];
        } elseif (isset($data['days-number-before'])) {
            $days = - $data['days-number-before']['value'];
        }

        $visibility_scopes = [];

        if (
            isset($data['visibility-scope']['meta']['item']['referenceKeys'])
        ) {
            $visibility_scopes = array_reduce($data['visibility-scope']['meta']['item']['referenceKeys'], function($carry, $item) use ($scopes) {
                if (in_array($item, $scopes)) {
                    $carry[] = $item;
                }

                return $carry;
            });
        }

        $result = [
            'deadline' => [
                'name' => isset($data['deadline-rule-description']) ? $data['deadline-rule-description']['value'] : null,
                'title' => isset($data['deadline-rule-title']) ? $data['deadline-rule-title']['value'] : null,
                'days' => $days,
                'days_type' => isset($data['day-types']) ? strtolower($data['day-types']['value']) : null,
                'best_practices' => isset($data['best-practice']) ? $data['best-practice']['value'] : null,
                'subtract_delivery_days' => isset($data['add-days-delivery']) ? $data['add-days-delivery']['meta']['item']['id'] === 1 : false,
                'visibility_scopes' => $visibility_scopes ? $visibility_scopes : []
            ]
        ];

        if (
            isset($data['triggering-event']['meta']['item']['referenceKey']) &&
            in_array($data['triggering-event']['meta']['item']['referenceKey'], Calculation::$events)
        ) {
            $result['deadline']['add_to'] = $data['triggering-event']['meta']['item']['referenceKey'];
        }

        return $result;
    }

    public function documentType()
    {
        if ($this->type !== 'document_type') {
            throw new Exception('Type must be: document_type');
        }
    
        return $this->belongsTo(DocumentType::class);
    }
    
    public function isDocumentCreated(): bool
    {
        if ($this->type !== 'document_type') {
            throw new Exception('Type must be: document_type');
        }

        return $this->document_type_id !== null;
    }

    public function updateDeadline()
    {
        if ($this->type !== 'edit_deadline') {
            throw new Exception('Type must be: edit_deadline');
        }

        $deadlineMap = $this->mapToDeadline();

        $deadline = Deadline::find($this->data['deadline_id']);
       // echo $this->data['deadline_id'];
      //  echo 'deadlines manual';
 

        foreach ($deadlineMap['deadline'] as $key => $value) {
            $deadline->{$key} = $value;
            
        }
        $deadline->update();
    }

    public function createDeadline(int $documentTypeId)
    {
        if ($this->type !== 'add_deadline') {
            throw new Exception('Type must be: add_deadline');
        }

        $deadlineMap = $this->mapToDeadline();

        $deadline = new Deadline();

        foreach ($deadlineMap['deadline'] as $key => $value) {
            $deadline->{$key} = $value;
        }

        $deadline->document_type_id = $documentTypeId;

        $deadline->save();
    }

    static public function getNotReviewedAndApprovedDeadlineRequestsForDocumentType(int $documentRequestId)
    {
        return self::whereRaw(
            "data->>'request_id' = ?",
            [$documentRequestId]
        )->where(function ($query) {
            $query->where('status_id', '=', null)->orWhere('status_id', '=', 1);
        })->where('type', 'add_deadline')->limit(30)->get();
    }

    static public function countAddDeadlineRequestsForDocumentRequest($documentRequestId) {
        return self::whereIn('type', ['add_deadline'])->whereRaw(
            "data->>'request_id' = ?",
            [$documentRequestId]
        )->count();
    }
}
