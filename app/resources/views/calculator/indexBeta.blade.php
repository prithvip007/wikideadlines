@extends('layouts.app', ['_CONTAINER_CLASS' => 'container_mw620'])

@section('head')
    <meta name="robots" content="noindex">
@endsection

@section('content')
<div class="container container_mw600">
    <section class="text-center">
        {{-- <div class="py-2 h1"><span class="fa fa-gavel"></span> WikiDeadlines</div> --}}
        <div class="w-100 d-flex justify-content-center">
            <img class="wd-logo" src="/images/wd-logo.png" />
        </div>

        <h2 class="my-3" style="font-weight: bold;">You've been invited to be a beta tester</h2>
        @include('partials.pricing-manifest', [
            'text' => "WikiDeadlines is a new crowdsourced legal deadlines application. As a beta tester, you can access all features for all California counties at no charge for six months (and we'll extend this for as long as you're sending feedback). WikiDeadlines works on all devices - mobile phones (iOS and Android), tablets, laptops, desktops, for all browsers."
        ])
    </section>
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            @if (Auth::user())
                <calculator
                    :calculation="{{ json_encode($calculation) }}" 
                    :is-attorney="{{Auth::user() ? (Auth::user()->isAttorney() ?? false ? 'true' : 'false') : 'false' }}"
                    :counties="{{ json_encode(App\Models\County::orderBy('name')->get())}}"
                    :authenticated="{{ Auth::user() ? 'true' : 'false' }}"
                    :show-hummer-icon="false"
                    initial-email="{{ Auth::user()->email ?? '' }}"
                    :document-request="{{ $documentRequest ? json_encode([ 'documentRequestId' => $documentRequest->id, 'documentTitle' => $documentRequest->mapToDocument()['document']['name'] ]) : 'undefined' }}"
                    :locales="{{ json_encode(__('events')) }}"
                    :document-elements="{{ $documentElements }}"
                    :deadline-rule-elements="{{ $deadlineRuleElements }}"
                    :jurisdiction-elements="{{ $jurisdictionElements }}"
                    :errors="{{ $errors->get('*') ? json_encode($errors->get('*')): '{}' }}"
                    :states="{{ json_encode($states) }}"
                    :document-types="{{ json_encode($document_types) }}"
                    :casename="{{ json_encode($casename) }}"
                    :delivery-methods="{{ json_encode($delivery_methods) }}"
                    :old-form-data="{{ old() ? json_encode(old()) : '{}' }}"
                    :can-calculate="{{ $canCalculate ? 'true' : 'false' }}"
                    :holidays="{{ json_encode( App\Models\State::with('holidays')->get()->makeVisible('holidays')->toArray() ) }}"
                    pricing-link-page="{{ route('pricing') }}"
                ></calculator>
            @else
                <login
                    v-bind:hide-registration-alert="false"
                    mode="signup"
                    v-bind:initial-step="1"
                    facebook-link="{{ route('social.connect', ['network' => 'facebook']) }}"
                    google-link="{{ route('social.connect', ['network' => 'google']) }}"
                    email-link="{{ route('signup.email') }}"
                ></login>
            @endif
        </div>
        <div class="col-12 text-center">
            <a
                href="#feedback"
                class="btn btn-light btn-sm"
            >
                <i class="fa fa-comment mr-1"></i> Feedback
            </a>
            <button
                v-share="{
                    text: 'Calculate your deadlines',
                    title: window.document.title,
                    url: window.location.href
                }"
                class="btn btn-light btn-sm"
            >
                <i class="fa fa-share-alt mr-1"></i> Share
            </button>
        </div>
    </div>
</div>
@endsection