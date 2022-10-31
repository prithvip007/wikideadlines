<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StripeProduct;
use App\Models\StripePlan;

class RemovePaymentProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove payment processing';

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
        StripeProduct::query()->delete();
        StripePlan::query()->delete();

        $this->info('Payment processing have been successfully deleted!');
    }
}
