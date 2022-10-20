<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StripePlan;
use App\Models\StripeProduct;

class initializeSubscriptionPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize subscription processing';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $plan = StripePlan::first();

        if ($plan) {
            $this->error('Stripe plans have been already initialized!');

            return;
        }

        $stripe = new \Stripe\StripeClient(config('app.stripe.secret'));

        $productMonthly = $stripe->products->create([
            'name' => 'WikiDeadlines Monthly Subscription'
        ]);

        $productAnnual = $stripe->products->create([
            'name' => 'WikiDeadlines Annual Subscription'
        ]);

        $prices = [
            [
                'product' => $productMonthly,
                'amount' => 19,
                'interval' => 'month',
            ],
            [
                'product' => $productAnnual,
                'interval' => 'year',
                'amount' => 179,
            ]
        ];

        foreach ($prices as $price) {
            $product = $price['product'];

            $stripePrice = $stripe->prices->create([
                'unit_amount' => $price['amount'] * 100,
                'currency' => 'usd',
                'recurring' => ['interval' => $price['interval']],
                'product' => $product->id,
            ]);

            $stripePlan = new StripePlan();

            $stripePlan->price_amount = $price['amount'];
            $stripePlan->price_id = $stripePrice->id;
            $stripePlan->product_id = $product->id;
            $stripePlan->interval = $price['interval'];

            $stripePlan->save();
        }

        $this->info('Subscription plans have been successfully initialized!');
    }
}
