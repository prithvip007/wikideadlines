@extends('layouts.settings', [ '_TITLE' => 'Profile' ])

@section('settings-card')
    <profile-settings
        :experience-levels="{{json_encode(\App\Models\ExperienceLevel::all()) }}"
        default-phone-number="{{ $phoneNumber }}"
        default-first-name="{{ $firstName }}"
        default-second-name="{{ $secondName }}"
        :default-experience-level={{ $experienceLevel }}
        default-email="{{ $email }}"
        link-to-authentication-page="{{ route('services') }}"
    ></profile-settings>
@endsection
