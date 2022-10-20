@extends('layouts.app', [
    '_TITLE' => (
        isset($_TITLE) ? $_TITLE . ' settings' : 'Settings'
    ) . ' – WikiDeadlines'
])

@section('content')
<div class="container">
    <h1 class="h2 mb-3">{{ isset($_TITLE) ? $_TITLE . ' settings' : 'Settings' }}</h1>
    <div class="row justify-content-center">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="row h-100 flex-nowrap flex-column">
                <div class="col-12 flex-basis-0">
                    <div class="row flex-md-column-reverse">
                        <div class="col-12 mt-md-0 mb-3">
                            <div class="card card-m">
                                <div class="navbar-light">
                                    <ul class="navbar-nav nav-light flex-column">
                                        <li class="nav-item px-3">
                                            <a class="nav-link {{ Request::route()->named('profile') ? 'active' : '' }}" href="{{ route('profile') }}"><i class="fa fa-user-circle-o mr-2"></i>Profile</a>
                                        </li>
                                        <li class="nav-item px-3">
                                            <a class="nav-link {{ Request::route()->named('subscription') ? 'active' : '' }}" href="{{ route('subscription') }}"><i class="fa fa-credit-card mr-2"></i>Subscription</a>
                                        </li>
                                        <li class="nav-item px-3">
                                            <a class="nav-link {{ Request::route()->named('services') ? 'active' : '' }}" href="{{ route('services') }}"><i class="fa fa-connectdevelop mr-2"></i>Authentication</a>
                                        </li>
                                        <li class="nav-item px-3">
                                            <a class="nav-link {{ Request::route()->named('investor') ? 'active' : '' }}" href="{{ route('investor') }}"><i class="fa fa-money mr-2"></i>
                                                Become a WikiDeadlines investor
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 mb-3 mb-md-0">
            <div class="card card-m">
                <div class="card-body">
                    @yield('settings-card')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
