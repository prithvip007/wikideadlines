<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\StripePlan;

class CheckoutController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            'billing_plan' => ['string', 'regex:(month|year)']
        ];

        $this->validate($request, $rules);

        $user = Auth::guard()->user();

        if (!$user->stripe_id) {
            $user->createAsStripeCustomer();
        }

        if ($user->subscribed('default', null, true)) {
            $url = $user->billingPortalUrl(route('home'));
            
            return response()->json(['portal_url' => $url]);
        }

        $plan = StripePlan::where('interval', $request->input('billing_plan'))->first();

        $checkout_session = \Stripe\Checkout\Session::create([
            'mode' => 'subscription',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.fail'),
            'client_reference_id' => $user->id,
            'customer' => $user->stripe_id,
            'payment_method_types' => ['card'],
            'line_items' => [[
                'quantity' => 1,
                'price' => $plan->price_id
            ]],
            'subscription_data' => [
                'metadata' => [
                    'user_id' => $user->id
                ]
            ]
        ]);

        return response()->json(['session_id' => $checkout_session['id']]);
    }
}
