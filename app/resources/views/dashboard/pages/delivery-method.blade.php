@extends('dashboard.layouts.index')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">View Delivery Method Data</h1>
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
                <div class="col-9">{{ $deliveryMethod->id }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Name:</div>
                <div class="col-9">{{ $deliveryMethod->name }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Description:</div>
                <div class="col-9">{{ $deliveryMethod->description }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Warning:</div>
                <div class="col-9">{{ $deliveryMethod->warning }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Days Type:</div>
                <div class="col-9">{{ $deliveryMethod->days_type }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Days:</div>
                <div class="col-9">{{ $deliveryMethod->days }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Outside State Days:</div>
                <div class="col-9">{{ $deliveryMethod->outside_state_days }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Outside Country Days:</div>
                <div class="col-9">{{ $deliveryMethod->outside_country_days }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Preselected:</div>
                <div class="col-9">{{ $deliveryMethod->preselected ? 'Yes' : 'No' }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Priority Order:</div>
                <div class="col-9">{{ $deliveryMethod->order }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Date Created:</div>
                <div class="col-9">{{ $deliveryMethod->created_at->format('l, F j, Y G:i A') }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Date Updated:</div>
                <div class="col-9">{{ $deliveryMethod->updated_at->format('l, F j, Y G:i A') }}</div>
            </div>
        </section>
    </div>
    <delivery-method-form
        trigger-hash="edit"
        :id="{{ $deliveryMethod->id }}"
        :initial-data="{{ json_encode($deliveryMethod->toArray()) }}"
    ></delivery-method-form>
    <delete-delivery-method :id="{{ $deliveryMethod->id }}" trigger-hash="delete"></delete-delivery-method>
@endsection
