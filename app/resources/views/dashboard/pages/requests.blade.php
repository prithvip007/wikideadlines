@extends('dashboard.layouts.index')

@section('content')
    <section class="mt-4">
        <h1 class="d-inline-block">
            @switch($type)
                @case('deadlines')
                    Deadline Requests {{ isset($documentRequest) ? "for  {$documentRequest->mapToDocument()['document']['name']}" : ''  }}
                    @break
                @case('documents')
                    Document Request
                    @break
                @default
                    Requests
            @endswitch
        </h1>
        <small>({{ $requestsCount }} requests)</small>
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
                @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->status()->first() ? $request->status()->first()->name : '' }}</td>
                    <td class="text-capitalize">{{ $request->getFormattedType() }}</td>
                    <td>
                        {{ $request->created_at }}
                    </td>
                    <td>
                        <a
                            class="d-flex align-items-center"
                            href="
                                @switch($type)
                                    @case('deadlines')
                                        {{ route('dashboard.deadline-rules.request', ['id' => $request->id]) }}
                                        @break
                                    @case('documents')
                                        {{ route('dashboard.documents.request', ['id' => $request->id]) }}
                                        @break
                                    @default
                                        #
                                @endswitch
                            "
                        >
                            <i class="fa fa-id-card-o mr-1" aria-hidden="true"></i>View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @include('dashboard.partials.pagination', [
            'items' => $requests
        ])
    <section>
@endsection
