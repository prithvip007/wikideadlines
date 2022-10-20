<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\URL;
use \Stripe\Stripe;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\IncomingExceptionEntry;
use App\Mail\UnexpectedErrorOccured;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Verify\Service',
            'App\Services\Twilio\Verification'
        );

        Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if ($this->app->environment() === 'production') {
            URL::forceScheme('https');
        }

        Stripe::setApiKey(config('app.stripe.secret'));

        Telescope::afterStoring(function (array $entries, $batchId) {
            if (app()->isLocal()) {
                return;
            }

            foreach ($entries as $entry) {
                if ($entry instanceof IncomingExceptionEntry) {
                    User::whereRoleIs('owner')->get()->each(function ($user) use ($entry) {
                        if (sizeof($user->error_notification_emails) === 0) {
                            return;
                        }

                        $unexpectedErrorOccured = new UnexpectedErrorOccured($entry, $user);

                        Mail::to($user->error_notification_emails)->queue($unexpectedErrorOccured); 
                    }, []);
                }
            }
        });
    }
}
