<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StripePlan;
use App\Models\StripeProduct;

class InitializePaymentProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize payment processing';

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
        $this->call('products:initialize');
        $this->call('subscription:initialize');
    }
}
