@extends('layouts.app', ['_HIDE_NAV' => true])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <profile-update :experience-levels="{{json_encode(\App\Models\ExperienceLevel::all()) }}"></profile-update>
        </div>
    </div>
</div>
@endsection
