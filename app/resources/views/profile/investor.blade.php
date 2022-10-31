@extends('layouts.settings', [ '_TITLE' => 'Profile' ])

@section('settings-card')
    <invest-settings
        :user="{{ json_encode([ 'last_name' => Auth::user()->second_name, 'first_name' => Auth::user()->first_name, 'email' => Auth::user()->email ]) }}"
        :next-application-days="{{ App\Models\InvestorApplication::getLeftDelayDaysForUser(Auth::user()) }}"
    ></invest-settings>
@endsection
