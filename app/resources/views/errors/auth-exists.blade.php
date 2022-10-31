@extends('layouts.app', ['_TITLE' => 'Success payment – WikiDeadlines'])

@section('content')
    <div class="container-lg">
        <div class="row h-100 flex-column">
            <div class="col-12 flex-grow-1 flex-basis-auto">
                <div class="row">
                    <div class="col-12">
                        @include('partials.picture-banner', [
                            'imageSource' => '/images/close.svg',
                            'imageAlt' => 'error',
                            'titleText' => 'This account already in use. Try another one',
                            'link' => Auth::check() ? route('services') : route('login'),
                            'linkText' => Auth::check() ? 'Settings' : 'Log in'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
