@extends('layouts.app', ['_TITLE' => 'Success payment – WikiDeadlines'])

@section('content')
    <div class="container-lg">
        <h1> After Payment sucesfully done </h1>
        @php  die;  @endphp 
        <div class="row h-100 flex-column">
            <div class="col-12 flex-grow-1 flex-basis-auto">
                <div class="row">
                    <div class="col-12">
                        @include('partials.picture-banner', [
                            'imageSource' => '/images/tick.svg',
                            'imageAlt' => 'credit card',
                            'titleText' => 'Subscription will be activated soon',
                            'link' => route('home'),
                            'linkText' => 'Calculate deadlines'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
