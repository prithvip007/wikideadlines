@extends('dashboard.layouts.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">View Deadline Rule Data</h1>
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
                <div class="col-9">{{ $deadlineRule->id }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Title:</div>
                <div class="col-9">{{ $deadlineRule->title }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Description:</div>
                <div class="col-9">{{ $deadlineRule->name }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Best Practices:</div>
                <div class="col-9">
                    <pre class="mb-0" style="white-space: pre-wrap;font-size:inherit;font-family:inherit;">{{ trim($deadlineRule->best_practices) }}</pre>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Days:</div>
                <div class="col-9">{{ $deadlineRule->days }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Event:</div>
                <div class="col-9">
                    {{
                        __("events.{$deadlineRule->add_to}.document_received")
                    }}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Days Type:</div>
                <div class="col-9">{{ $deadlineRule->days_type }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Check Date on Proof of Service Preciseness:</div>
                <div class="col-9">{{ $deadlineRule->check_dps_preciseness ? 'Yes' : 'No' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Calculate If The Same Judge:</div>
                <div class="col-9">{{ $deadlineRule->calculate_if_same_judge ? 'Yes' : 'No' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Filter scopes:</div>
                <div class="col-9">{{
                    array_reduce($deadlineRule->visibility_scopes, function ($carry, $scope) {
                        $scopeName = __("scopes.{$scope}");

                        $carry = $carry . $scopeName . ', ';

                        return $carry;
                    }, '')
                }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Date Created:</div>
                <div class="col-9">{{ $deadlineRule->created_at->format('l, F j, Y G:i A') }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Date Updated:</div>
                <div class="col-9">{{ $deadlineRule->updated_at->format('l, F j, Y G:i A') }}</div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>References</h4>
            <div class="row">
                <div class="col-3">Document Type:</div>
                <div class="col-9">
                    <a href="{{ route('dashboard.document', [ 'id' => $deadlineRule->document_type()->first()->id ]) }}">{{ $deadlineRule->document_type()->first()->name }}</a>
                </div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>Statistics</h4>
            <div class="row">
                <div class="col-3">Thumbs up:</div>
                <div class="col-9">{{ $deadlineRule->deadlineThumbs()->count() }}</div>
            </div>
        </section>
    </div>
    <rule-form
        :id="{{ $deadlineRule->id }}"
        trigger-hash="edit"
        :initial-data="{{ json_encode($deadlineRule->toArray()) }}"
        :events="{{ json_encode(App\Models\Calculation\Calculation::getLocalesForActiveEvents()) }}"
        :document-types="{{ json_encode(App\Models\DocumentType::orderBy('name', 'asc')->with('dateQuestions.dateQuestionType')->get()) }}"
    ></rule-form>
    <delete-deadline-modal :id="{{ $deadlineRule->id }}" trigger-hash="delete"></delete-deadline-modal>
@endsection
