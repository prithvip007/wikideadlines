<?php

namespace App\Models;

use Laravel\Cashier\Billable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Calculation\Calculation;
use App\Models\StripePlan;
use App\Models\ExperienceLevel;
use App\Models\StripeProduct;
use Carbon\Carbon;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Billable {
        subscribed as protected traitSubscribed;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['phone_number', 'first_name', 'email', 'facebook_id', 'google_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'free_calculations_updated_at' => 'datetime',
        'notification_emails' => 'array',
        'error_notification_emails' => 'array'
    ];

    public function isAttorney()
    {
        return $this->experienceLevel()->first()->id === 1;
    }

    public function experienceLevel()
    {
        return $this->belongsTo(ExperienceLevel::class);
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // TODO: probaly it's not correct to use id instead of password. Check it
        return $this->id;
    }

    public function subscribed($name = 'default', $plan = null, $force = false)
    {
        if (config('app.subscription.enabled') && !$force) {
            return true;
        }

        return $this->traitSubscribed($name, $plan);
    }

    public function calculations()
    {
        return $this->hasMany(Calculation::class);
    }

    public function getSubscriptionStatus(string $name = 'default'): string {
        if ($this->subscribed($name, null, true)) {
            return $this->subscription($name)->cancelled() ? 'Canceled' : 'Active';
        }
        
        return 'Inactive';
    }

    public function getSubscriptionEndDate(string $name = 'default'): string {
        if ($this->subscription($name)) {
            return $this->subscription($name)->ends_at ? $this->subscription($name)->ends_at->format('l, F j, Y') : 'In progress';
        }
        
        return '';
    }

    function getNextFreeCalculationsUpdateDate(): Carbon {
        $date = $this->free_calculations_updated_at->clone();

        $date->day += config('app.subscription.free_calculations_update_period');

        return $date;
    }

    public function createCheckoutForSearchProduct(array $metadata, string $successURL, string $cancelURL): \Laravel\Cashier\Checkout
    {
        $searchProduct = StripeProduct::getSearchProduct();

        return $this->checkout($searchProduct->price_id, [
                'mode' => 'payment',
                'success_url' => $successURL,
                'cancel_url' => $cancelURL,
                'client_reference_id' => $this->id,
                'customer' => $this->stripe_id,
                'payment_method_types' => ['card'],
                'submit_type' => 'pay',
                'payment_intent_data' => [
                    'metadata' => array_merge($metadata, [
                        'user_id' => $this->id,
                        'description' => 'user paid for one search'
                    ])
                ]
            ]);
    }

    public function getSubscriptionPlan(string $name = 'default'): ?string {
        $stripePlans = StripePlan::all();

        $plans = [
            'year' => 'yearly', 
            'month' => 'monthly'
        ];

        $plan = 'basic';

        foreach ($stripePlans as $stripePlan) {
            if ($this->subscribed($name, $stripePlan->price_id, true)) {
                $plan = isset($plans[$stripePlan->interval])
                    ? $plans[$stripePlan->interval]
                    : $plan;
            }
        }

        return $plan;
    }
}
