@extends('dashboard.layouts.index')

@section('content')
    <section class="mt-4">
        <h1 class="d-inline-block">Deadline Requests</h1>
        <small>({{ $deadlineRequestsCount }} requests)</small>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Date Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deadlineRequests as $deadlineRequest)
                <tr>
                    <td>{{ $deadlineRequest->id }}</td>
                    <td>{{ $deadlineRequest->status()->first() ? $deadlineRequest->status()->first()->name : '' }}</td>
                    <td class="text-capitalize">{{ $deadlineRequest->getFormattedType() }}</td>
                    <td>
                        {{ $deadlineRequest->created_at }}
                    </td>
                    <td>
                        <a class="d-flex align-items-center" href="{{ route('dashboard.deadline-rules.request', ['id' => $deadlineRequest->id]) }}"><i class="fa fa-id-card-o mr-1" aria-hidden="true"></i>View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @include('dashboard.partials.pagination', [
            'items' => $deadlineRequests
        ])
    <section>
@endsection
