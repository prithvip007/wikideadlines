<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\Deadline;
use App\Models\DocumentType;
use App\Models\Calculation\Calculation;
use App\Models\RequestStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as RequestModel;
use App\Models\Interviews\RuleInterview;
use App\Models\Snapshots\DeadlineSnapshot;
use Exception;

class DeadlineRulesController extends Controller
{
    private $optionalKeys = ['deadline-rule-title', 'deadline-rule-description', 'authority-source', 'authority-link'];

    public function index(Request $request)
    {
        $id = (int) $request->id;

        $deadlineRule = Deadline::findOrFail($id);

        return view('dashboard.pages.deadline-rule', [ 'deadlineRule' => $deadlineRule ]);
    }

    public function all(Request $request)
    {
        $this->validate(request(), [
            'document_id' => 'nullable|integer'
        ]);

        $this->validatePagination();

        $document = null;

        if (isset($request->document_id)) {
            $deadlineRules = Deadline::where('document_type_id', $request->document_id)->orderByDesc('id')->paginate($request->per_page);
            $deadlinesCount = Deadline::where('document_type_id', $request->document_id)->count();
            $document = DocumentType::find($request->document_id);
        } else {
            $deadlineRules = Deadline::orderByDesc('id')->paginate($request->per_page);

            $deadlinesCount = Deadline::count();
        }

        $requestId = (int) $request->request_id;

        $userRequest = RequestModel::where('type', 'add_deadline')->find($requestId);

        $initialData = null;

        if ($userRequest) {
            $initialData = $userRequest->mapToDeadline()['deadline'];
        }

        return view('dashboard.pages.deadline-rules', [
            'deadlineRules' => $deadlineRules ,
            'deadlinesCount' => $deadlinesCount,
            'document' => $document,
            'initialData' =>  $initialData
        ]);
    }

    public function getEditDeadlineData(Request $request)
    {
        $interview = new RuleInterview();

        $deadlineId = $request->id;
        $deadline = Deadline::findOrFail($deadlineId);

        $requestEmail = null;
        $deadlineRequestData = null;

        if ($request->requestId) {
            $deadlineRequest = RequestModel::where([
                'type' => 'edit_deadline',
                'id' => (int) $request->requestId
            ])->first();

            if ($deadlineRequest) {
                $requestEmail = $deadlineRequest->data['email'];

                $deadlineRequestData = [
                    'name' => '',
                    'requiresDeliveryMethod' => true,
                    'daysType' => 'calendar',
                    'bestPractices' => '',
                    'days' => 0,
                    'deliveryMethods' => [],
                    'eventTime' => null,
                    'acceptableMethodsLimit' => null,
                    'authoritySource' => null,
                    'anotherDelvieryMethod' => null,
                    'authorityLink' => null,
                    'deadlineRuleTitle' => null
                ];

                
                foreach ($deadlineRequest->data['deadlines'] as $deadlineData) {
                    try {
                        switch ($deadlineData['meta']['key']) {
                            case 'deadline-rule-description':
                            $deadlineRequestData['name'] = $deadlineData['value'];
                            break;
                        case 'add-days-delivery':
                            $deadlineRequestData['requiresDeliveryMethod'] = $deadlineData['meta']['item']['id'] === 1 ? true : false;
                            break;
                        case 'day-types':
                            $deadlineRequestData['daysType'] = $deadlineData['meta']['item']['id'] === 1 ? 'court' : 'calendar';
                            break;
                        case 'delivery-methods-list':
                            $deadlineRequestData['deliveryMethods'] = $deadlineData['meta']['item']['id'];
                            break;
                        case 'days-number-after':
                        case 'days-number-before':
                            $deadlineRequestData['days'] = (int) $deadlineData['value'];
                            break;
                        case 'event-time':
                            $deadlineRequestData['eventTime'] = $deadlineData['meta']['item']['id'];
                            break;
                        case 'best-practice':
                            $deadlineRequestData['bestPractices'] = $deadlineData['value'];
                            break;
                        case 'acceptable-methods-limit':
                            $deadlineRequestData['acceptableMethodsLimit'] = (int) $deadlineData['meta']['item']['id'];
                            break;
                        case 'deadline-rule-title':
                            $deadlineRequestData['deadlineRuleTitle'] = $deadlineData['value'];
                            break;
                        case 'authority-source':
                            $deadlineRequestData['authoritySource'] = (int) $deadlineData['meta']['item']['id'];
                            break;
                        case 'another-delviery-method':
                            $deadlineRequestData['anotherDelvieryMethod'] = $deadlineData['value'];
                            break;
                        case 'authority-link':
                            $deadlineRequestData['authorityLink'] = $deadlineData['value'];
                            break;
                    }
                    } catch (Exception $e) {
                        //
                    }
                }
            }
        }

        $documentName = $deadline->document_type()->first()->name;
        $deadline = DeadlineSnapshot::create($deadline);

        $beforeElements = $interview->getFilledFromDeadline($deadline, $documentName, $this->optionalKeys);
        $afterElements = $deadlineRequestData ? $interview->getFilledFromArray($deadlineRequestData, $documentName, $this->optionalKeys) : $beforeElements;

        return response()->json([
            'afterElements' => $afterElements,
            'beforeElements' => $beforeElements,
            'documentName' => $documentName,
            'requestEmail' => $requestEmail,
        ]);
    }

    public function createDeadline(Request $request)
    {
        $rules = [
            'title' => 'string|max:4000',
            'name' => 'required|string|max:4000',
            'days' => 'required|integer|min:-32768|max:32767',
            'days_type' => 'string|in:court,calendar',
            'best_practices' => 'string|nullable|max:4000',
            'document_type_id' => 'exists:App\Models\DocumentType,id',
            'visibility_scopes' => 'required|array',
            "visibility_scopes.*"  => "string|in:no_display:document_received,no_check:document_received,no_display:document_to_send,no_check:document_to_send",
            'add_to' => 'in:' . implode(',', Calculation::getActiveEvents()),
            'subtract_delivery_days' => 'boolean',
            'check_dps_preciseness' => 'boolean',
            'calculate_if_same_judge' => 'boolean'
        ];

        $this->validate($request, $rules);

        $deadline = new Deadline();

        foreach ($rules as $key => $value) {
            if ($request->has($key)) {
                $deadline->{$key} = $request->{$key};
            }
        }

        $deadline->save();

        return response()->json([
            'deadline' => $deadline->toArray()
        ]);
    }

    public function updateDeadline(Request $request)
    {    
        $deadlineId = $request->id;
        $deadline = Deadline::findOrFail($deadlineId);

        $rules = [
            'title' => 'string|max:4000',
            'name' => 'string|max:4000',
            'days' => 'integer|min:-32768|max:32767',
            'days_type' => 'string|in:court,calendar',
            'best_practices' => 'string|nullable|max:4000',
            'document_type_id' => 'exists:App\Models\DocumentType,id',
            'visibility_scopes' => 'required|array',
            "visibility_scopes.*"  => "string|in:no_display:document_received,no_check:document_received,no_display:document_to_send,no_check:document_to_send",
            'add_to' => 'in:' . implode(',', Calculation::getActiveEvents()),
            'subtract_delivery_days' => 'boolean',
            'check_dps_preciseness' => 'boolean',
            'calculate_if_same_judge' => 'boolean'
        ];

        $this->validate($request, $rules);

        foreach ($rules as $key => $value) {
            if ($request->has($key)) {
                $deadline->{$key} = $request->{$key};
            }
        }

        $deadline->audit_user_id = Auth::id();

        $deadline->save();

        return response()->json([
            'deadline' => $deadline->toArray()
        ]);
    }

    public function getRequests(Request $request)
    {
        $this->validatePagination();

        $this->validate(request(), [
            'document_request_id' => 'nullable|integer'
        ]);

        $documentRequest = null;

        if (isset($request->document_request_id)) {
            $requests = RequestModel::whereIn('type', ['add_deadline'])->whereRaw(
                "data->>'request_id' = ?",
                [$request->document_request_id]
            )->orderByDesc('id')->paginate($request->per_page);

           $documentRequest = RequestModel::find($request->document_request_id);

           $requestsCount = RequestModel::whereIn('type', ['add_deadline'])->whereRaw(
                "data->>'request_id' = ?",
                [$request->document_request_id]
            )->count();
        } else {
            $requests = RequestModel::whereIn('type', ['edit_deadline', 'add_deadline'])->orderByDesc('id')->paginate($request->per_page);
            $requestsCount = RequestModel::whereIn('type', ['edit_deadline', 'add_deadline'])->count();
        }


        return view('dashboard.pages.requests', [ 'requests' => $requests, 'requestsCount' => $requestsCount, 'type' => 'deadlines', 'documentRequest' => $documentRequest ]);
    }

    public function getRequest(Request $request)
    {
        $id = (int) $request->id;

        $request = RequestModel::whereIn('type', ['edit_deadline', 'add_deadline'])->findOrFail($id);

        $statuses = RequestStatus::all();

        return view('dashboard.pages.request', [ 'request' => $request, 'statuses' => $statuses ]);
    }

    public function delete(Request $request) {
        $id = (int) $request->id;

        $deadlineRule = Deadline::findOrFail($id);

        $deadlineRule->delete();

        return response()->json([
            'redirect_to' => route('dashboard.deadline-rules')
        ]);
    }
}
