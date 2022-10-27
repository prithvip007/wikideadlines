<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('calculate'));
})->name('home');


Route::get('/test', function () {
    return view('privacy.test');
});

// an old path for 'calculate' route
Route::get('/calculate', function () {
    return redirect(route('calculate'));
});

// an old path for 'history' route
Route::get('/history', function () {
    return redirect(route('history'));
});


Route::get('/privacy-policy', function () {
    return view('privacy.index');
})->name('privacy');

Route::get('/free-legal-deadline-calculator', 'CalculatorController@index')
    ->middleware('profile.check')
    ->name('calculate');

// TODO: remove
Route::get('/beta-test', 'CalculatorController@indexBeta')
    ->middleware('profile.check')
    ->name('beta-test');

Route::middleware(['auth'])->group(function () {
    Route::get('/calculation/{key}', 'CalculatorController@calculation')
        ->name('calculation');

    Route::get('/auth/profile-update', 'AuthController@profile')
        ->middleware('profile.check.reverse')
        ->name('authentication.profile');

    Route::middleware(['profile.check'])->group(function () {
        Route::get('/settings/profile', 'ProfileController@index')
            ->name('profile');

        Route::get('/settings/services', 'ServicesController@index')
            ->name('services');

        Route::get('/settings/subscription', 'SubscriptionController@index')
            ->name('subscription');
        
        Route::get('/settings/investor', 'InvestorController@index')
            ->name('investor');

        Route::get('/my-deadlines', 'HistoryController@index')
            ->name('history');

        Route::get('/pricing', 'PricingController@index')
            ->name('pricing');

        // TODO: remove
        Route::post('/beta-test', 'CalculatorController@calculate');
        Route::post('/free-legal-deadline-calculator', 'CalculatorController@calculate');

        Route::middleware(['role:admin'])->prefix('dashboard')->group(function () {
            Route::get('/', function () {
                return redirect(route('dashboard.users'));
            })->name('dashboard');
            Route::get('/users/{id}', 'Dashboard\UserController@index')->name('dashboard.user');
            Route::get('/users', 'Dashboard\UserController@all')->name('dashboard.users');;
            Route::get('/deadline-rules/requests', 'Dashboard\DeadlineRulesController@getRequests')->name('dashboard.deadline-rules.requests');
            Route::get('/deadline-rules/request/{id}', 'Dashboard\DeadlineRulesController@getRequest')->name('dashboard.deadline-rules.request');
            Route::get('/deadline-rules', 'Dashboard\DeadlineRulesController@all')->name('dashboard.deadline-rules');
            Route::get('/deadline-rule/{id}', 'Dashboard\DeadlineRulesController@index')->name('dashboard.deadline-rule');
            Route::get('/documents', 'Dashboard\DocumentTypesController@all')->name('dashboard.documents');
            Route::get('/document/{id}', 'Dashboard\DocumentTypesController@index')->name('dashboard.document');
            Route::get('/documents/requests', 'Dashboard\DocumentTypesController@getRequests')->name('dashboard.documents.requests');
            Route::get('/documents/request/{id}', 'Dashboard\DocumentTypesController@getRequest')->name('dashboard.documents.request');
            Route::get('/feedback/{id}', 'Dashboard\FeedbackController@index')->name('dashboard.feedback');
            Route::get('/feedbacks', 'Dashboard\FeedbackController@all')->name('dashboard.feedbacks');
            Route::get('/delivery-methods', 'Dashboard\DeliveryMethodController@all')->name('dashboard.delivery-methods');
            Route::get('/delivery-method/{id}', 'Dashboard\DeliveryMethodController@index')->name('dashboard.delivery-method');
        });
    });

    Route::post('/logout', 'AuthController@logout')
        ->name('logout');
});

Route::get('/social-auth/{network}/connect', 'SocialAuthController@connect')
    ->where('network', 'facebook|google')
    ->name('social.connect');

Route::get('/social-auth/{network}/callback', 'SocialAuthController@callback')
    ->where('network', 'facebook|google');

Route::get('/calculation/calendar/ical/{key}', 'CalculatorController@generateIcalFile')
    ->name('calculation.ical')
    ->middleware('calculation.accessable.check');

Route::middleware(['guest'])->group(function () {
    Route::get('/signup', 'AuthController@index')
        ->name('signup');

    Route::get('/login', 'AuthController@index')
        ->name('login');

    Route::get('/login/email', 'AuthController@emailAuthentication')
        ->name('login.email');

    Route::get('/singup/email', 'AuthController@emailAuthentication')
        ->name('signup.email');
});

Route::get('/auth/authenticate/{jwt}', 'AuthController@authenticateByLink')->name('auth.token');

Route::get('/deadline/{id}/edit', function (){
    redirect(route('dashboard'));
})->name('deadline.edit');

Route::get('/success-payment', function () {
    return view('payments.success');
})->name('payment.success');

Route::get('/fail-payment', function () {
    return view('payments.fail');
})->name('payment.fail');

Route::post('/stripe/webhook', 'WebhookController@handleWebhook');
