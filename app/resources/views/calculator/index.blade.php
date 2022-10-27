@extends('layouts.app', ['_CONTAINER_CLASS' => 'container_mw620'])

@section('content')
<div class="container container_mw600">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <calculator
                :calculation="{{ json_encode($calculation) }}"            
                :is-attorney="{{Auth::user() ? (Auth::user()->isAttorney() ?? false ? 'true' : 'false') : 'false' }}"
                :show-hummer-icon="false"
                :counties="{{ json_encode(App\Models\County::orderBy('name')->get())}}"
                :authenticated="{{ Auth::user() ? 'true' : 'false' }}"
                initial-email="{{ Auth::user()->email ?? '' }}"
                :document-request="{{ $documentRequest ? json_encode([ 'documentRequestId' => $documentRequest->id, 'documentTitle' => $documentRequest->mapToDocument()['document']['name'] ]) : 'undefined' }}"
                :locales="{{ json_encode(__('events')) }}"
                :document-elements="{{ $documentElements }}"
                :deadline-rule-elements="{{ $deadlineRuleElements }}"
                :jurisdiction-elements="{{ $jurisdictionElements }}"
                :errors="{{ $errors->get('*') ? json_encode($errors->get('*')): '{}' }}"
                :states="{{ json_encode($states) }}"
                :document-types="{{ json_encode($document_types) }}"
                :delivery-methods="{{ json_encode($delivery_methods) }}"
                :old-form-data="{{ old() ? json_encode(old()) : '{}' }}"
                :holidays="{{ json_encode( App\Models\State::with('holidays')->get()->makeVisible('holidays')->toArray() ) }}"
                :can-calculate="{{ $canCalculate ? 'true' : 'false' }}"
                pricing-link-page="{{ route('pricing') }}"
            ></calculator>
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