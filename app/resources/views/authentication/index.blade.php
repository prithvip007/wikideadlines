@extends('layouts.app', ['_HIDE_AUTH_NAV' => true])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <login
                v-bind:hide-registration-alert="{{ $step === 2 ? 'true' : 'false' }}"
                mode="{{ $isSignup ? 'signup' : 'logging' }}"
                v-bind:initial-step="{{ $step }}"
                facebook-link="{{ route('social.connect', ['network' => 'facebook']) }}"
                google-link="{{ route('social.connect', ['network' => 'google']) }}"
                email-link="{{ $isSignup ? route('signup.email') : route('login.email') }}"
            ></login>
        </div>
    </div>
</div>
@endsection
