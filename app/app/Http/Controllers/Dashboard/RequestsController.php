<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deadline;
use \App\Models\Request as UserRequest;
use \App\Models\DocumentType;
use \App\Models\RequestStatus;
use Illuminate\Validation\ValidationException;

class RequestsController extends Controller
{
    public function update(Request $request)
    {
        $id = (int) $request->id;

        $rules = [
            'status_id' => 'exists:App\Models\RequestStatus,id'
        ];

        $this->validate($request, $rules);

        $message  = '';

        $userRequest = UserRequest::findOrFail($id);

        $status = $userRequest->status()->first();

        if ($status && $status->isApproved()) {
            throw ValidationException::withMessages([
                'status' => 'Status can\'t be changed'
            ]);
        }

        foreach ($rules as $key => $value) {
            if (isset($request->{$key})) {
                $userRequest->{$key} = $request->{$key};
            }
        }

        $status = RequestStatus::find($request->status_id);
        
        $documentNotApprovedId = null;

        if ($status->isApproved()) {

            if ($userRequest->type === 'document_type') {
                $documentMap = $userRequest->mapToDocument();

                $documentType = new DocumentType();

                foreach ($documentMap['document'] as $key => $value) {
                    $documentType->{$key} = $value;
                }

                $documentType->save();
                $documentType->deliveryMethods()->sync($documentMap['deliveryMethods']->pluck('id'));

                if ($documentMap['standard_motion_briefing']) {
                    Deadline::createStandardMotionDeadlines($documentType->id);
                }

                $userRequest->document_type_id = $documentType->id;

                $deadlineRequests = UserRequest::getNotReviewedAndApprovedDeadlineRequestsForDocumentType($userRequest->id);

                $allDeadlineRequests = count($deadlineRequests);
                $addedDeadlines = 0;

                foreach ($deadlineRequests as $deadlineRequest) {
                    try {
                        $deadlineRequest->createDeadline($documentType->id);
                        $deadlineRequest->status_id = 1;
                        $deadlineRequest->save();
                        $addedDeadlines++;
                    } catch (\Exception $exception) {
                        \Log::error('Creating a deadline from deadline request (' . $deadlineRequest->id . ') failed', compact('exception'));
                    }
                }

                $message = "Document has been successfully created. {$addedDeadlines}/{$allDeadlineRequests} are added to the created document.";

                if ($addedDeadlines !== $allDeadlineRequests) {
                    $message = $message . ' Try to add the rest deadlines manually';
                }

            } elseif ($userRequest->type === 'edit_document_type') {
                $documentMap = $userRequest->mapToDocument();

                $documentType = DocumentType::findOrFail($userRequest['data']['document_id']);

                foreach ($documentMap['document'] as $key => $value) {
                    $documentType->{$key} = $value;
                }

                $documentType->save();
                $documentType->deliveryMethods()->sync($documentMap['deliveryMethods']->pluck('id'));
            } elseif ($userRequest->type === 'edit_deadline') {
              
                if (isset($userRequest->mapToDeadline()['deadline']['add_to']) === false) {
                    throw ValidationException::withMessages([
                        'triggering_event' => 'Triggering event isn\'t supported'
                    ]);
                }
               
                $userRequest->updateDeadline();
            } elseif ($userRequest->type === 'add_deadline') {
                if (isset($userRequest->mapToDeadline()['deadline']['add_to']) === false) {
                    throw ValidationException::withMessages([
                        'triggering_event' => 'Triggering event isn\'t supported'
                    ]);
                }

                if (isset($userRequest->data['request_id'])) {
                    $addDocumentRequest = UserRequest::find($userRequest->data['request_id']);
                
                    if ($addDocumentRequest->isDocumentCreated()) {
                        $userRequest->createDeadline($addDocumentRequest->document_type_id);
                    } else {
                        $documentNotApprovedId = $userRequest->data['request_id'];
                    }
                } elseif (isset($userRequest->data['document_id'])) {
                    $userRequest->createDeadline($userRequest->data['document_id']);
                }
            }
        }
    
        $userRequest->save();

        return response()->json([
            'link_to_document_request' => $documentNotApprovedId !== null
                ? route('dashboard.documents.request', ['id' => $documentNotApprovedId])
                : null,
            'message' => $message
        ]);
    }
}
