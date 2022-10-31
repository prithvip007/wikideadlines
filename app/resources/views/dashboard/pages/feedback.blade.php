@extends('dashboard.layouts.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            Feedback
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
                <div class="col-3">Text:</div>
                <div class="col-9">
                    <p style="max-height: 300px; overflow: auto">{{ $request->data['text'] }}</p>
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
    </div>
@endsection
