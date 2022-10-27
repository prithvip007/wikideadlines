@extends('layouts.app', ['_TITLE' => $calculation->case_name . ' – WikiDeadlines'])

@section('widgets')
    @include('partials.share')
@endsection
@section('content')
    <div class="container-lg">
        <div class="row h-100 flex-column">
            <div class="col-12 flex-basis-0">
                <div class="page-header row">
                    <div class="col-md-12 mb-2 d-flex">
                        <h1 class="text-break flex-grow-1 mb-0 h2">{{ $calculation->case_name }}</h1>
                        <div style="flex: 0 0 auto;">
                            <button
                                v-print="{ title: '{{ $printTitle }}' }"
                                class="btn btn-light d-print-none"
                                type="button"
                            >
                                <i class="fa fa-2x fa-print"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 flex-grow-1 flex-basis-auto">
                <div class="calculation__body row">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="row h-100 flex-nowrap flex-column">
                            <div class="col-12 flex-basis-0">
                                <div class="row flex-md-column-reverse">
                                    @guest
                                        <div class="d-print-none mb-3 col-12">
                                            <div class="alert mb-0 alert-success text-center">
                                                <a href="{{ route('login') }}">Create a free account now</a><br>
                                                to save deadlines
                                            </div>
                                        </div>
                                    @endguest
                                    <div class="d-print-none mb-3 col-12">
                                        <shareable-link
                                            link="{{ route('calculation', ['key' => $calculation->key]) }}"></shareable-link>
                                    </div>
                                    <div class="col-12 mt-md-0 mb-3">
                                        <div class="card card-m">
                                            <div class="card-body">
                                                <table class="inputs-table">
                                                    <tbody>
                                                    <tr>
                                                        <td><i class="fa fa-file"></i></td>
                                                        <td>
                                                            <label class="mb-0">Document Type</label>
                                                            <div class="font-weight-bold">
                                                                {{ $calculation->getSnapshotInstance()->document_type->name }}
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><i class="fa fa-flag"></i></td>
                                                        <td>
                                                            <!-- Its actually not a Jurisdiction. Is a State. We should refactor the whole app to support jurisdictions later when more details become available -->
                                                            <label class="mb-0">Jurisdiction</label>
                                                            <div class="font-weight-bold">
                                                                {{ $calculation->getSnapshotInstance()->state->name }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr is="edit-county"
                                                        :counties="{{ json_encode(App\Models\County::all()) }}"
                                                        :initial-county="{{ $calculation->county()->first() ? json_encode($calculation->county()->first()) : 'undefined'}}"
                                                        trigger-hash="county"
                                                        case-name="{{ $calculation->case_name }}"
                                                    >
                                                    </tr>
                                                    @if($calculation->getSnapshotInstance()->delivery_method)
                                                        <tr>
                                                            <td><i class="fa fa-truck"></i></td>
                                                            <td>
                                                                <label class="mb-0">Delivery Method</label>
                                                                <div class="font-weight-bold">
                                                                    By {{ $calculation->getSnapshotInstance()->delivery_method->name }}
                                                                </div>
                                                                @if($calculation->delivery_area === 1)
                                                                    <div class="small text-muted">
                                                                        Outside the country
                                                                    </div>
                                                                @elseif($calculation->delivery_area === 2)
                                                                    <div class="small text-muted">
                                                                        Outside the state
                                                                    </div>
                                                                @endif
                                                                @if(
                                                                    $calculation->county()->first() &&
                                                                    $calculation->county()->first()->e_filing === 'mandatory' &&
                                                                    $calculation->getSnapshotInstance()->delivery_method &&
                                                                    $calculation->getSnapshotInstance()->delivery_method->reference_key !== 'e_filing'
                                                                )
                                                                    <div class="small text-danger text-muted">
                                                                        E-filing is required for any party represented by an attorney, but it is recommended e-filing be used by self-represented parties as it is generally easier, lower cost, and more reliable than other delivery methods.
                                                                    </div>
                                                                @elseif(
                                                                    ( 
                                                                        (
                                                                            $calculation->county()->first() &&
                                                                            $calculation->county()->first()->e_filing !== 'mandatory'
                                                                        ) ||
                                                                        (
                                                                            $calculation->county()->first() &&
                                                                            $calculation->county()->first()->e_filing === 'mandatory' &&
                                                                            $calculation->getSnapshotInstance()->delivery_method &&
                                                                            $calculation->getSnapshotInstance()->delivery_method->reference_key !== 'e_filing'
                                                                        )
                                                                    ) &&
                                                                    $isCorrectDeliveryMethod === false
                                                                )
                                                                    <div class="small text-danger text-muted">
                                                                        Incorrect delivery method
                                                                    </div>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @foreach($calculationDates as $key => $dateData)
                                                        @if (!$dateData['value'])
                                                            @continue
                                                        @endif
                                                        <tr>
                                                            <td><i class="fa {{ $dateData['icon'] }}"></i></td>
                                                            <td>
                                                                <label class="mb-0">{{ $dateData['question'] }}</label>
                                                                <div class="font-weight-bold">
                                                                    {{
                                                                        $dateData['type'] === 'datetime'
                                                                            ? $dateData['value']->format('l, F j, Y G:i A')
                                                                            : $dateData['value']->format('l, F j, Y')
                                                                        
                                                                    }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    @foreach ($calculation->dateAnswers()->get() as $dateAnswer)
                                                        <tr>
                                                            <td><i class="fa {{
                                                                $dateAnswer->dateQuestion()->first()->dateQuestionType()->first()->type === 'datetime'
                                                                    ? 'fa-clock-o' :  'fa-calendar'
                                                                }}"></i></td>
                                                            <td>
                                                                <label class="mb-0">{{ $dateAnswer->dateQuestion()->first()->{"question_$calculation->type"} }}</label>
                                                                <div class="font-weight-bold">
                                                                    {{
                                                                        $dateAnswer->dateQuestion()->first()->dateQuestionType()->first()->type === 'datetime'
                                                                            ? $dateAnswer->value->setTimezone($calculation->state->timezone)->format('l, F j, Y G:i A')
                                                                            : $dateAnswer->value->setTimezone($calculation->state->timezone)->format('l, F j, Y')
                                                                    }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    @foreach ($calculation->earliestHearingDates()->get() as $earliestHearingDate)
                                                        @if ($loop->first)
                                                            <tr>
                                                                <td><i class="fa fa-clock-o"></i></td>
                                                                <td>
                                                                    <label class="mb-0">Earliest hearing date you can set this motion using</label>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <label class="mb-0">{{ $earliestHearingDate->deliveryMethod()->first()->name }}:</label>
                                                                <div class="font-weight-bold">
                                                                    {{
                                                                        $earliestHearingDate->value->setTimezone($calculation->state->timezone)->format('l, F j, Y')
                                                                    }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    @if($calculation->hearing_courthouse)
                                                        <tr>
                                                            <td><i class="fa fa-building"></i></td>
                                                            <td>
                                                                <label class="mb-0">Hearing Courthouse</label>
                                                                <div class="font-weight-bold">
                                                                    {{ $calculation->hearing_courthouse }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @if($calculation->hearing_courtroom)
                                                        <tr>
                                                            <td><i class="fa fa-balance-scale"></i></td>
                                                            <td>
                                                                <label class="mb-0">Hearing Courtroom</label>
                                                                <div class="font-weight-bold">
                                                                    {{ $calculation->hearing_courtroom }}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @if($calculation->same_judge)
                                                        <tr>
                                                            <td><i class="fa fa-gavel"></i></td>
                                                            <td>
                                                                <div class="font-weight-bold">
                                                                    This hearing to be conducted by the same judge that is assigned for all purposes
                                                                    to this case
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center flex-basis-auto flex-grow-1 d-flex align-items-end flex-column flex-md-row">
                                <a href="#feedback"
                                   class="d-print-none sticky-feedback btn w-100 d-md-none btn-warning">
                                    <i class="fa fa-comment mr-1"></i> Feedback
                                </a>
                                <a href="#feedback" 
                                   class="d-print-none sticky-feedback btn d-none d-md-inline-block btn-light btn-sm">
                                    <i class="fa fa-comment mr-1"></i> Feedback
                                </a>
                                <button
                                    v-share="{
                                        text: 'Deadlines for case: {{ $calculation->case_name }}',
                                        title: window.document.title,
                                        url: window.location.href
                                    }"
                                    class="d-print-none sticky-feedback btn d-none d-md-inline-block btn-light btn-sm"
                                >
                                    <i class="fa fa-share-alt mr-1"></i> Share
                                </button>
                                <button
                                    v-share="{
                                        text: 'Deadlines for case: {{ $calculation->case_name }}',
                                        title: window.document.title,
                                        url: window.location.href
                                    }"
                                    class="d-print-none sticky-feedback btn w-100 d-md-none btn-light mt-3 border"
                                >
                                    <i class="fa fa-share-alt mr-1"></i> Share
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 mb-3 mb-md-0">
                        @if($calculation->accessable === false)
                            <section class="d-flex flex-column align-items-center">
                                <img style="width: 60px" src="/images/payment-method.svg"  alt="Waiting"/>
                                <div class="text-center" style="width: 70%">
                                    <h3>
                                        Waiting for payment.
                                    </h3>
                                    <p>
                                        Usually it takes 2-3 minutes.
                                        If you have paid for the calculation, but the deadlines don't appear, please, click <a href="#feedback">here</a> to contact us.
                                    </p>
                                </div>
                            </section>
                        @else
                            <calculations
                                initial-email="{{ Auth::user()->email ?? '' }}"
                                document-best-practices="{{ $calculation->getSnapshotInstance()->document_type->best_practices }}"
                                :document-elements="{{ json_encode($documentElements) }}"
                                pencil-link="#no-op"
                                :has-subscription="{{ $calculation->accessable ? 'true' : 'false' }}"
                                image-source-banner="/images/lock.svg"
                                :document-id="{{ $calculation->getSnapshotInstance()->document_type->id }}"
                                image-alt-banner="credit card"
                                title-text-banner="This function is available only for users with subscription"
                                link-banner={{ route('pricing') }}
                                link-text-banner="Buy now"
                                google-link="{{ route('calculation.ical', [ 'key' => $calculation->key ]) }}"
                                document-type-name="{{ $calculation->getSnapshotInstance()->document_type->name }}"
                                :calculation="{{ json_encode($calculationView) }}"
                                :deadlines="{{ json_encode($deadlinesView) }}"
                            ></calculations>
                            <div class="alert alert-info mb-3 d-print-none card-m bg-white">
                                Users just like you are adding rules to WikiDeadlines every day. We currently have almost all California civil litigation rules.
                                <a href="#addrule">Please add a deadline or best practice for {{ $calculation->getSnapshotInstance()->document_type->name }} here
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </edit-county>
    <add-deadline-rule
        initial-email="{{ Auth::user()->email ?? '' }}"
        :exclude-items="['authority-source-frcp']"
        :document-id="{{ $calculation->getSnapshotInstance()->document_type->id }}"
        document-title="{{ $calculation->getSnapshotInstance()->document_type->name }}"
        :calculation-id="{{$calculation->id}}"
        :elements="{{ $interviewElements }}"
        trigger-hash="addrule"
        ref="addDocumentType"
    ></add-deadline-rule>
    @if(Auth::check() === false)
        <login-modal
            trigger-hash="login"
            facebook-link="{{ route('social.connect', ['network' => 'facebook']) }}"
            google-link="{{ route('social.connect', ['network' => 'google']) }}"
        ></login-modal>
    @endif
@endsection
