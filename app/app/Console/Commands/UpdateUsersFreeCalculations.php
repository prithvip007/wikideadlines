<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateUsersFreeCalculations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-free-calculations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update free calculations for users';

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
        DB::update(
            '
                UPDATE users 
                SET free_calculations = free_calculations + ?, free_calculations_updated_at = current_timestamp 
                WHERE DATE_PART(\'day\', date_trunc(\'day\', current_timestamp) - date_trunc(\'day\', free_calculations_updated_at) ) >= ?;
            ',
            [config('app.subscription.free_calculations_quantity'), config('app.subscription.free_calculations_update_period')]
        );

        $this->info('Free calculations updated');
    }
}
