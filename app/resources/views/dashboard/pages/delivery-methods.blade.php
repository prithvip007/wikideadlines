@extends('dashboard.layouts.index')

@section('content')
    <section class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="d-flex align-items-end">
                <h1 class="m-0">Delivery Methods</h1>
                <small>({{ $ddeliveryMethodsCount }} rules)</small>
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
                <th>Days Type</th>
                <th>Days</th>
                <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveryMethods as $deliveryMethod)
                <tr>
                    <td>{{ $deliveryMethod->id }}</td>
                    <td style="width:45%" >
                        {{ $deliveryMethod->name }}
                    </td>
                    <td>{{ $deliveryMethod->days_type }}</td>
                    <td>{{ $deliveryMethod->days }} </td>
                    <td>
                        <a class="d-flex align-items-center" href="{{ route('dashboard.delivery-method', ['id' => $deliveryMethod->id]) }}"><i class="fa fa-id-card-o mr-1" aria-hidden="true"></i>View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @include('dashboard.partials.pagination', [
            'items' => $deliveryMethods
        ])
    <section>
    <delivery-method-form trigger-hash="add"></delivery-method-form>
@endsection