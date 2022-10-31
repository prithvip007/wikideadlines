<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StripeProduct;

class InitializeProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize products processing';

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
        $product = StripeProduct::first();

        if ($product) {
            $this->error('Products have been already initialized!');
            return;
        }

        $stripe = new \Stripe\StripeClient(config('app.stripe.secret'));

        $searchProduct = $stripe->products->create([
            'name' => 'WikiDeadlines Search'
        ]);

        $stripePrice = $stripe->prices->create([
            'unit_amount' => 9 * 100,
            'currency' => 'usd',
            'product' => $searchProduct->id,
        ]);
        
        $product = new StripeProduct();

        $product->name = 'search';
        $product->price_amount = 9;
        $product->price_id = $stripePrice->id;;
        $product->product_id = $searchProduct->id;

        $product->save();

        $this->info('Products have been successfully initialized!');
    }
}
