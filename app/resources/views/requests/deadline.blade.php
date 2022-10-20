@extends('layouts.app', [ '_TITLE' => 'Edit deadline – WikiDeadlines' ])

@section('content')
    <edit-deadline-request
        :id="{{ $deadlineId }}"
        :after-elements="{{ $afterElements }}"
        :before-elements="{{ $beforeElements }}"
        document-name="{{ $documentName }}"
        request-date="{{ $requestDate ? $requestDate->format('l, F j, Y') : '' }}"
        request-email="{{ $requestEmail ? $requestEmail : '' }}"
    ></edit-deadline-request>
@endsection
