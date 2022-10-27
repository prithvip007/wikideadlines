@php
    const TITLE = 'Your Cases and Deadlines';
@endphp

@extends('layouts.app', ['_TITLE' => TITLE . ' – WikiDeadlines'])

@section('content')
    <div class="container-lg">
        <div class="h-100">
            <div class="page-header">
                <h2 class="text-break mb-3">{{ TITLE }}</h2>
            </div>
            <div style="overflow: hidden;" class="card bg-white mb-3 card-m">
                <div class="card-header d-flex align-items-center justify-content-end bg-white">
                    <a class="btn btn-link btn-link-orange-soda" href="{{ route('calculate') }}">
                        <i class="fa fa-lg fa-plus"></i>
                    </a>
                </div>
                <div class="card-body">
                    @if ($hasSubscription === false)
                        @include('partials.commercial-function')
                    @elseif ($calculations->total() === 0)
                        @include('partials.picture-banner', [
                            'imageSource' => '/images/box.svg',
                            'imageAlt' => 'empty box',
                            'titleText' => 'You haven\'t added any cases yet',
                            'link' => route('calculate'),
                            'linkText' => 'Add a new case'
                        ])
                    @else
                        <my-deadlines
                            :pinned="{{ json_encode([
                                'case_name' => App\Models\Calculation\Calculation::$defaultCaseName,
                                'all_count' => App\Models\Calculation\Calculation::where('case_name', null)->count(),
                                'query' => '',
                                'add_calculation_url' => route('calculate')
                            ]) }}"
                            :calculations="{{ json_encode($results) }}"
                        ></my-deadlines>
                    @endif
                </div>
            </div>
            @if ($hasSubscription)
                <div class="pagination-container position-static col-12 pagination-m">
                    {{ $calculations->onEachSide(3)->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
