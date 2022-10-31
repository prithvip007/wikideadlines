@extends('layouts.settings', [ '_TITLE' => 'Authentication' ])

@section('settings-card')
    <services-settings
        phone-number="{{ Auth::user()->phone_number }}"
        email="{{ Auth::user()->email }}"
        :is-facebook-connected-initial="{{ $isFacebookConnectedInitial ? 'true' : 'false' }}"
        :is-google-connected-initial="{{ $isGoogleConnectedInitial ? 'true' : 'false' }}"
        connect-to-facebook-link="{{ route('social.connect', ['network' => 'facebook']) }}"
        connect-to-google-link="{{ route('social.connect', ['network' => 'google']) }}"
    ></services-settings>
@endsection
