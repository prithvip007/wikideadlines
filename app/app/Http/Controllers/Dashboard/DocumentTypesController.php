<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\Deadline;
use App\Models\DocumentType;
use App\Models\DeliveryMethod;
use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;
use App\Models\RequestStatus;

class DocumentTypesController extends Controller
{
    public function index(Request $request)
    {
        $id = (int) $request->id;

        $document = DocumentType::with('deliveryMethods')->findOrFail($id);

        $deliveryMethods = DeliveryMethod::all();

        $deadlinesCount = Deadline::where('document_type_id', $id)->count();

        return view('dashboard.pages.document', [ 'document' => $document, 'deliveryMethods' => $deliveryMethods, 'deadlinesCount' => $deadlinesCount ]);
    }

    public function all(Request $request)
    {

        $this->validatePagination();
    
        $documents = DocumentType::orderByDesc('id')->paginate($request->per_page);

        $requestId = (int) $request->request_id;

        $userRequest = RequestModel::where('type', 'document_type')->find($requestId);

        $documentsCount = DocumentType::count();
        $deliveryMethods = DeliveryMethod::all();

        $initialData = null;

        if ($userRequest) {
            $requestDocumentMap = $userRequest->mapToDocument();
            $initialData = array_merge($requestDocumentMap['document'], [ 'delivery_methods' => $requestDocumentMap['deliveryMethods'] ]);
        }

        return view('dashboard.pages.documents', [
            'documents' => $documents,
            'initialData' =>  $initialData,
            'documentsCount' => $documentsCount,
            'deliveryMethods' => $deliveryMethods
        ]);
    }

    public function create(Request $request)
    {
        $directModelKeyRules = [
            'name' => 'required|string|max:4000',
            'small_description' => 'nullable|string|max:100',
            'keywords' => 'nullable|string|max:4000',
            'ask_hearing_courthouse' => 'required|boolean',
            'ask_hearing_courtroom' => 'required|boolean'
        ];

        $undirectModelKeyRules = [
            'delivery_methods' => 'nullable|exists:App\Models\DeliveryMethod,id',
            'standard_motion_briefing' => 'required|boolean',
        ];

        $rules = array_merge($undirectModelKeyRules, $directModelKeyRules);

        $this->validate($request, $rules);

        $document = new DocumentType();

        foreach ($directModelKeyRules as $key => $value) {
            if ($request->has($key)) {
                $document->{$key} = $request->{$key};
            }
        }

        $document->save();
        $document->deliveryMethods()->sync($request->delivery_methods);

        if ($request->standard_motion_briefing) {
            Deadline::createStandardMotionDeadlines($document->id);
        }

        return response()->json([
            'document' => $document->toArray()
        ]);
    }

    public function update(Request $request)
    {
        $documentId = $request->id;
        $document = DocumentType::findOrFail($documentId);

        $directModelKeyRules = [
            'name' => 'required|string|max:4000',
            'small_description' => 'nullable|string|max:100',
            'best_practices' => 'string|nullable|max:4000',
            'keywords' => 'nullable|string|max:4000',
            'ask_hearing_courthouse' => 'boolean',
            'ask_hearing_courtroom' => 'boolean'
        ];

        $undirectModelKeyRules = [
            'delivery_methods' => 'nullable|exists:App\Models\DeliveryMethod,id'
        ];

        $rules = array_merge($undirectModelKeyRules, $directModelKeyRules);

        $this->validate($request, $rules);

        foreach ($directModelKeyRules as $key => $value) {
            if ($request->has($key)) {
                $document->{$key} = $request->{$key};
            }
        }

        $document->save();

        $document->deliveryMethods()->sync($request->delivery_methods);

        return response()->json([
            'document' => $document->toArray()
        ]);
    }

    public function getRequests(Request $request)
    {
        echo "hear ";
die;
        $this->validatePagination();

        $requests = RequestModel::whereIn('type', ['document_type', 'edit_document_type'])->orderByDesc('id')->paginate($request->per_page);;

        $requestsCount = RequestModel::whereIn('type', ['document_type', 'edit_document_type'])->count();

        return view('dashboard.pages.requests', [ 'requests' => $requests, 'requestsCount' => $requestsCount, 'type' => 'documents' ]);
    }

    public function getRequest(Request $request)
    {
        $id = (int) $request->id;

        $request = RequestModel::whereIn('type', ['document_type', 'edit_document_type'])->findOrFail($id);

        $statuses = RequestStatus::all();

        return view('dashboard.pages.request', [ 'request' => $request, 'statuses' => $statuses ]);
    }

    public function delete(Request $request) {
        $id = (int) $request->id;

        $document = DocumentType::findOrFail($id);

        $document->delete();

        return response()->json([
            'redirect_to' => route('dashboard.documents')
        ]);
    }
}
