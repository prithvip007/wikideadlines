<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StripePlan;

class PricingController extends Controller
{
    public function index()
    {
        $user = Auth::guard()->user();
      
        $subscription = $user->subscription();
        $cancelled = $subscription === null ? false : $subscription->cancelled();

        $stripePlans = StripePlan::all();

        $plans = [];

        foreach ($stripePlans as $stripePlan) {

            $plans[] = [
                'price' => $stripePlan->price_amount,
                'active' => $user->subscribedToPlan($stripePlan->price_id),
                'interval' => $stripePlan->interval,
                'canceled' => $cancelled,
            ];
           
        }

        $publishableKey = config('app.stripe.key');
       


        return view('pricing.index', compact('plans', 'publishableKey'));
    }
    

    public function pricingnow()
    {
        echo "reach hear";
        die;
        exit ("gr00");
        $user = Auth::guard()->user();
      
        $subscription = $user->subscription();
        $cancelled = $subscription === null ? false : $subscription->cancelled();

        $stripePlans = StripePlan::all();

        $plans = [];

        foreach ($stripePlans as $stripePlan) {

            $plans[] = [
                'price' => $stripePlan->price_amount,
                'active' => $user->subscribedToPlan($stripePlan->price_id),
                'interval' => $stripePlan->interval,
                'canceled' => $cancelled,
            ];
           
        }

        $publishableKey = config('app.stripe.key');
       


        return view('pricing.index', compact('plans', 'publishableKey'));
    }
}
