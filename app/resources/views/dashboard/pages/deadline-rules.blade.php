@extends('dashboard.layouts.index')

@section('content')
    <section class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-end">
                <h1 class="m-0">Deadline Rules {{ isset($document) ? "for {$document->name}" : '' }}</h1>
                <small>({{ $deadlinesCount }} rules)</small>
            </div>
            <div>
                <a href="#add"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Add</a>
            </div>
        </div>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th>#</th>
                <th>Description</th>
                <th>Document Type</th>
                <th>Days Type</th>
                <th>Days</th>
                <th>Event</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deadlineRules as $deadlineRule)
                <tr>
                    <td>{{ $deadlineRule->id }}</td>
                    <td style="width:45%" >
                        {{ $deadlineRule->name }}
                    </td>
                    <td>{{ $deadlineRule->document_type()->first()->name }}</td>
                    <td>{{ $deadlineRule->days_type }}</td>
                    <td>{{ $deadlineRule->days }} </td>
                    <td>
                        {{
                            __("events.{$deadlineRule->add_to}.document_received")
                         }}
                    </td>
                    <td>
                        <a class="d-flex align-items-center" href="{{ route('dashboard.deadline-rule', ['id' => $deadlineRule->id]) }}"><i class="fa fa-id-card-o mr-1" aria-hidden="true"></i>View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @include('dashboard.partials.pagination', [
            'items' => $deadlineRules
        ])
    <section>
    <rule-form
        trigger-hash="add"
        :initial-data="{{ json_encode($initialData) }}"
        :events="{{ json_encode(App\Models\Calculation\Calculation::getLocalesForActiveEvents()) }}"
        :document-types="{{ json_encode(App\Models\DocumentType::orderBy('name', 'asc')->with('dateQuestions.dateQuestionType')->get()) }}"
    ></rule-form>
@endsection