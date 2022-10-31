@extends('dashboard.layouts.index')

@section('content')
    <h1>View User Data</h1>
    <div class="mt-4">
        <section style="background-color:#ebeced" class="p-2">
            <h4>General Information</h4>
            <div class="row">
                <div class="col-3">Id:</div>
                <div class="col-9">{{ $user->id }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">First Name:</div>
                <div class="col-9">{{ $user->first_name }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Last Name:</div>
                <div class="col-9">{{ $user->second_name }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Phone Number:</div>
                <div class="col-9">{{ $user->phone_number }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Email:</div>
                <div class="col-9">{{ $user->email }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Roles:</div>
                <div class="col-9">{{ $user->roles->implode('display_name', ', ') }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Experience Level:</div>
                <div class="col-9">{{ $user->experienceLevel()->first()->name }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Registration Date (UTC+0):</div>
                <div class="col-9">{{ $user->created_at->format('l, F j, Y g:i A') }}</div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>Subscription</h4>
            <div class="row">
                <div class="col-3">Plan:</div>
                <div class="col-9 text-capitalize">{{ $user->getSubscriptionPlan() }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">End date:</div>
                <div class="col-9">
                    {{ $user->getSubscriptionEndDate() }}
                </div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>Free searches</h4>
            <div class="row">
                <div class="col-3">Available:</div>
                <div class="col-9 text-capitalize">{{ $user->free_calculations }}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Next update date (UTC+0):</div>
                <div class="col-9">
                    {{ $user->getNextFreeCalculationsUpdateDate()->format('l, F j, Y') }}
                </div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>Connected Services</h4>
            <div class="row">
                <div class="col-3">Facebook:</div>
                <div class="col-9">
                    {{ $user->facebook_id !== null ? 'Yes' : 'No' }}
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-3">Google:</div>
                <div class="col-9">
                    {{ $user->google_id !== null ? 'Yes' : 'No' }}
                </div>
            </div>
        </section>
        <section style="background-color:#ebeced" class="mt-4 p-2">
            <h4>Statistics</h4>
            <div class="row">
                <div class="col-3">Calculated Deadlines:</div>
                <div class="col-9">
                    {{ $user->calculations_count }}
                </div>
            </div>
        </section>
    </div>
@endsection
