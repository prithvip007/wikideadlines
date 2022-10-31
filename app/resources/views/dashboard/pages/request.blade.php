@extends('dashboard.layouts.index')

@php
    switch ($request->type) {
        case 'add_deadline':
            $REQUEST_PAGE_TITLE = 'Deadline Request';
            $REQUEST_STATUS_WARNING = 'Not all properties will be included in a created deadline. Deadlines that don\'t have an existing event trigger won\'t be created.';
            break;
        case 'edit_deadline':
            $REQUEST_PAGE_TITLE = 'Deadline Request';
            $REQUEST_STATUS_WARNING = 'Not all properties will be updated on a modified deadline.';
            break;
        case 'document_type':
            $REQUEST_PAGE_TITLE = 'Document Request';
            $REQUEST_STATUS_WARNING = 'Not all properties will be included in a created document. If this document request has associated deadline requests, they will be created automatically.';
            break;
        default:
            $REQUEST_PAGE_TITLE = 'Request';
            $REQUEST_STATUS_WARNING = '';
    }
@endphp


@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            {{ $REQUEST_PAGE_TITLE }}
        </h1>
    </div>
    <div class="mt-4">
        <section style="background-color:#ebeced" class="p-2">
            <h4>General Information</h4>
            <div class="row">
                <div class="col-3">Id:</div>
                <div class="col-9">{{ $request->id }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Status:</div>
                <div class="col-9">
                    {{ $request->status()->first() ? $request->status()->first()->name : '' }}
                    <a href="#edit-status"><i class="fa fa-pencil-square-o ml-1" aria-hidden="true"></i>Edit</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Interview:</div>
                <div class="col-9">
                    <a href="#edit"><i class="fa fa-eye mr-1" aria-hidden="true"></i>Show</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Type:</div>
                <div class="col-9 text-capitalize">
                    {{ $request->getFormattedType() }}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Email:</div>
                <div class="col-9">
                    <a href="mailto:{{ $request->data['email'] }}">{{ $request->data['email'] }}</a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Date Created:</div>
                <div class="col-9">{{ $request->created_at->format('l, F j, Y G:i A') }}</div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>References</h4>
            @if ($request->type === 'document_type' && $request->documentType()->first()) 
                <hr>
                <div class="row">
                    <div class="col-3">Created Document Type:</div>
                    <div class="col-9">
                        <a href="{{ route('dashboard.document', ['id' => $request->documentType()->first()->id ]) }}">
                            {{ $request->documentType()->first()->name }}
                        </a>
                    </div>
                </div>
            @endif
            @if ($request->type === 'document_type') 
                <hr>
                <div class="row">
                    <div class="col-3">Related Deadline Requests:</div>
                    <div class="col-9">
                        <a href="{{ route('dashboard.deadline-rules.requests', ['document_request_id' => $request->id ]) }}">
                            {{ \App\Models\Request::countAddDeadlineRequestsForDocumentRequest($request->id) }}
                        </a>
                    </div>
                </div>
            @endif
            @if ($request->type === 'edit_document_type' && isset($request->data['document_id']))
                <hr>
                <div class="row">
                    <div class="col-3">Related Document:</div>
                    <div class="col-9">
                        <a href="{{ route('dashboard.document', ['id' => $request->data['document_id'] ]) }}">
                            {{ \App\Models\DocumentType::find($request->data['document_id'])->name }}
                        </a>
                    </div>
                </div>
            @endif
            @if ($request->type === 'add_deadline' && isset($request->data['request_id']))
                <hr>
                <div class="row">
                    <div class="col-3">Related Document Request:</div>
                    <div class="col-9">
                        <a href="{{ route('dashboard.documents.request', ['id' => $request->data['request_id'] ]) }}">
                            {{ \App\Models\Request::find($request->data['request_id'])->mapToDocument()['document']['name'] }}
                        </a>
                    </div>
                </div>
            @endif
            @if ($request->type === 'add_deadline' && isset($request->data['document_id']))
                <hr>
                <div class="row">
                    <div class="col-3">Related Document:</div>
                    <div class="col-9">
                        <a href="{{ route('dashboard.document', ['id' => $request->data['document_id'] ]) }}">
                            {{ \App\Models\DocumentType::find($request->data['document_id'])->name }}
                        </a>
                    </div>
                </div>
            @endif
            @if ($request->type === 'edit_deadline' && isset($request->data['deadline_id']))
                <hr>
                <div class="row">
                    <div class="col-3">Related Deadlines:</div>
                    <div class="col-9">
                        <a href="{{ route('dashboard.deadline-rule', ['id' => $request->data['deadline_id'] ]) }}">
                            {{ \App\Models\Deadline::find($request->data['deadline_id'])->title ?? 'Untitled' }}
                        </a>
                    </div>
                </div>
            @endif
        </section>
    </div>
    @switch($request->type)
        @case('edit_deadline')
        @case('add_deadline')
            <edit-deadline
                external-page-link="{{
                    $request->type === 'edit_deadline'
                        ? route('dashboard.deadline-rule', ['id' => $request->data['deadline_id']]) . '#edit'
                        : route('dashboard.deadline-rules', [ 'request_id' => $request->id ]) . '#add'
                }}"
                external-page-text="{{
                    $request->type === 'edit_deadline'
                        ? 'Go to the edit a deadline rule page'
                        : 'Go to the add a deadline rule page'
                }}"
                :interview="{{ json_encode($request->data['deadlines']) }}"
                trigger-hash="edit"
            ></edit-deadline>
            @break
        @case('document_type')
        @case('edit_document_type')
            <edit-deadline
                external-page-link="{{ route('dashboard.documents', [ 'request_id' => $request->id ]) . '#add' }}"
                external-page-text="Go to the add a document page"
                :interview="{{ json_encode($request->data['deadlines']) }}"
                trigger-hash="edit"
            ></edit-deadline>
            @break
        @default
    @endswitch
    <edit-request-status
        :id="{{ $request->id }}"
        warning="{{ $REQUEST_STATUS_WARNING }}"
        {{ $request->status()->first() ? ':initial-status=' . $request->status()->first()->id  : ''  }}
        :status-list="{{ json_encode($statuses->toArray()) }}"
        trigger-hash="edit-status"
    ></edit-request-status>
@endsection
