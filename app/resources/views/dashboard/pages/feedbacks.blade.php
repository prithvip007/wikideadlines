@extends('dashboard.layouts.index')

@section('content')
    <section class="mt-4">
        <h1 class="d-inline-block">
            Feedbacks
        </h1>
        <small>({{ $requestsCount }} requests)</small>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>
                        {{ $request->created_at }}
                    </td>
                    <td>
                        <a
                            class="d-flex align-items-center"
                            href="{{ route('dashboard.feedback', ['id' => $request->id]) }}"
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
