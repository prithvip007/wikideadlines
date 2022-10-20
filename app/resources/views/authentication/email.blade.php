@extends('layouts.app', ['_HIDE_AUTH_NAV' => true])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <login-email
                mode="{{ $isSignup ? 'signup' : 'logging' }}"
            ></login-email>
        </div>
    </div>
</div>
@endsection
