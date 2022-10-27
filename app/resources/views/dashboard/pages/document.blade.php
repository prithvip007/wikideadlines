@extends('dashboard.layouts.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">View Document Data</h1>
        <div>
            <a class="text-danger mr-4" href="#delete"><i class="fa fa-trash mr-1" aria-hidden="true"></i>Delete</a>
            <a href="#edit"><i class="fa fa-pencil-square-o mr-1" aria-hidden="true"></i>Edit</a>
        </div>
    </div>
    <div class="mt-4">
        <section style="background-color:#ebeced" class="p-2">
            <h4>General Information</h4>
            <div class="row">
                <div class="col-3">Id:</div>
                <div class="col-9">{{ $document->id }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Name:</div>
                <div class="col-9">{{ $document->name }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Description:</div>
                <div class="col-9">{{ $document->small_description }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Keywords:</div>
                <div class="col-9">{{ $document->keywords }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Best Practices:</div>
                <div class="col-9">{{ $document->best_practices }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Delivery Methods:</div>
                <div class="col-9">{{ $document->deliveryMethods()->get()->implode('name', ', ') }}</div>
            </div>
            @if ($document->days_before_hd_calendar !== null)
                <hr>
                <div class="row">
                    <div class="col-3">Number of Calendar Days before hearing date that motion must be filed with court:</div>
                    <div class="col-9">{{ $document->days_before_hd_calendar }}</div>
                </div>
            @elseif ($document->days_before_hd_court !== null)
                <hr>
                <div class="row">
                    <div class="col-3">Number of Court Days before hearing date that motion must be filed with court:</div>
                    <div class="col-9">{{ $document->days_before_hd_court }}</div>
                </div>
            @endif
            <hr>
            <div class="row">
                <div class="col-3">Ask Hearing Courthouse:</div>
                <div class="col-9">{{ $document->ask_hearing_courthouse ? 'Yes' : 'No' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Ask Hearing Courtroom:</div>
                <div class="col-9">{{ $document->ask_hearing_courtroom ? 'Yes' : 'No' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Date Created:</div>
                <div class="col-9">{{ $document->created_at->format('l, F j, Y G:i A') }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Date Updated:</div>
                <div class="col-9">{{ $document->updated_at->format('l, F j, Y G:i A') }}</div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>References</h4>
            <div class="row">
                <div class="col-3">Deadlines:</div>
                <div class="col-9">
                    <a href="{{ route('dashboard.deadline-rules', [ 'document_id' => $document->id ]) }}">{{ $deadlinesCount }}</a>
                </div>
            </div>
        </section>
    </div>
    <document-form
        :id="{{ $document->id }}"
        trigger-hash="edit"
        :delivery-methods="{{ json_encode($deliveryMethods) }}"
        :initial-data="{{ json_encode($document->toArray()) }}"
    ></document-form>
    <delete-document-modal :id="{{ $document->id }}" trigger-hash="delete"></delete-document-modal>
@endsection
