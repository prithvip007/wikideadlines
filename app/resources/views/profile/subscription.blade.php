@extends('layouts.settings', [ '_TITLE' => 'Subscription' ])

@section('settings-card')
    <div class="row">
        <div class="col-12">
            <div>
                <h6>Free searches
                    <i
                        data-toggle="tooltip"
                        data-placement="top"
                        title="You will receive {{ config('app.subscription.free_calculations_quantity') }} free search every {{ config('app.subscription.free_calculations_update_period') }} days. The next update: {{ $user->getNextFreeCalculationsUpdateDate()->format('F j\t\h') }}"
                        class="fa fa-question-circle-o help"
                    ></i>
                </h6>
                <p class="font-weight-bold">{{ $user->free_calculations }}</p>
            </div>
            <hr>
            <div>
                <h6>Subscription status</h6>
                <p class="font-weight-bold">
                    {{
                        $user->getSubscriptionStatus()
                    }}
                </p>
            </div>
            @if ($user->subscribed('default', null, true) && $user->subscription()->cancelled())
                <hr>
                <div>
                    <h6>Subscription end date</h6>
                    <p class="font-weight-bold">{{ $user->subscription()->ends_at->format('l, F j, Y') }}</p>
                </div>
            @endif
            @if ($user->getSubscriptionPlan() !== null)
                <hr>
                <div>
                    <h6>Subscription plan</h6>
                    <p class="font-weight-bold text-capitalize">{{ $user->getSubscriptionPlan() }}</p>
                </div>
            @endif
        </div>

        <div class="col-12">
            <div class="bg-light text-center d-flex align-items-center justify-content-center flex-column mt-3 py-3 rounded-m bg-botticelli border border-light-blue">
                <h6>
                    @if ($user->subscribed('default', null, true) === false)
                        You don't have an active subscription
                    @else 
                        You can update, cancel or renew your subscription plan any time
                    @endif
                </h6>
    
                <a href="{{ route('pricing') }}" class="btn btn-md btn-link">
                    @if ($user->subscribed('default', null, true) === false)
                        Activate
                    @else 
                        Manage
                    @endif
                </a>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/tooltips.js') }}" type="application/javascript" defer></script>
@endsection
