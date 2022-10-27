@extends('dashboard.layouts.index')

@section('content')
    <section class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-end">
                <h1 class="m-0">Documents</h1>
                <small>({{ $documentsCount }} documents)</small>
            </div>
            <div>
                <a href="#add"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Add</a>
            </div>
        </div>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                <th>#</th>
                <th>Name</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)
                <tr>
                    <td>{{ $document->id }}</td>
                    <td>{{ $document->name }}</td>
                    <td>
                        <a class="d-flex align-items-center" href="{{ route('dashboard.document', ['id' => $document->id]) }}"><i class="fa fa-id-card-o mr-1" aria-hidden="true"></i>View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @include('dashboard.partials.pagination', [
            'items' => $documents
        ])
    <section>
        <document-form
            trigger-hash="add"
            :initial-data="{{ json_encode($initialData) }}"
            :delivery-methods="{{ json_encode($deliveryMethods) }}"
        ></document-form>
@endsection