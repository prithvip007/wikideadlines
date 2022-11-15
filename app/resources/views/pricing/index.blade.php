@extends('layouts.app', ['_TITLE' => 'Pricing – WikiDeadlines'])

@section('head.scripts') 
  <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
@php   echo "<pre>";
  print_r(plans);  @endphp 
    <div class="container-lg">
        <div class="row h-100 flex-column">
            <div class="col-12 flex-basis-0">
                <div class="container_mw700 px-3 py-3 pt-md-4 pb-md-4 mx-auto text-center">
                    <h1>WikiDeadlines Pricing</h1>
                    <h5 class="mb-0 py-2">{{ $title ?? "Help win your case by knowing crucial deadlines and best practices." }} <i class="fa fa-asterisk" aria-hidden="true" style="position: relative;top: -7px;font-size: 6px;"></i></h5>
                  </div>
            </div>
            <div class="col-12 flex-grow-1 flex-basis-auto">
              <pricing
                publishable-key="{{ $publishableKey }}"
                :plans="{{ json_encode($plans) }}"
              ></pricing>
            </div>
            <div class="col-12 flex-grow-1 flex-basis-auto">
              <p class="text-muted py-2">
                <i class="fa fa-asterisk" aria-hidden="true" style="position: relative;top: -7px;font-size: 6px;"></i>
                You get one free search every 30 days - just create your account.
                No credit card required.
                Get additional searches for free by adding and validating documents, rules, and best practices entered by other users.
                Get civil litigation deadlines for all of California for one low monthly fee (no added cost for each county).
                You can also purchase searches for $9 per search or get unlimited searches for an unlimited number of cases for just $19 per month (or pay $179 for 12 months at $14.92/month and get 21% off).  WikiDeadlines works on all devices, no download required.
              </p>
            </div>
        </div>
    </div>
@endsection
