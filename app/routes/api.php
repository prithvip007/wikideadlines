<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/request/send', 'RequestsController@send');

Route::post('/social-auth/{network}/disconnect', 'SocialAuthController@disconnect')->where('network', 'facebook|google');

Route::post('/auth/send-code', 'AuthController@sendCode')->middleware('guest');
Route::post('/auth/confirm-code', 'AuthController@confirmCode')->middleware('guest');

Route::post('/auth/email/send-code', 'AuthController@sendEmailCode')->middleware('guest');
Route::post('/auth/email/confirm-code', 'AuthController@confirmEmailCode')->middleware('guest');

Route::post('/profile/send-code', 'ProfileController@sendCode')->middleware('auth');
Route::post('/profile/confirm-code', 'ProfileController@confirmCode')->middleware('auth');

Route::post('/profile/send-email-code', 'ProfileController@sendEmailCode')->middleware('auth');
Route::post('/profile/confirm-email-code', 'ProfileController@confirmEmailCode')->middleware('auth');

Route::post('/deadline/{id}/thumb', 'DeadlineController@createThumb')->middleware('auth');
Route::delete('/deadline/{id}/thumb', 'DeadlineController@deleteThumb')->middleware('auth');

Route::patch('/deadline/{id}', 'DeadlineController@editeDeadline')
    ->middleware('auth')
    ->middleware('role:admin');

Route::get('calculations/names', 'CalculatorController@getCaseNames')->middleware('auth');
Route::get('calculations', 'CalculatorController@getCaluclationsByCaseName')->middleware('auth');
Route::post('calculations/county', 'CalculatorController@updateCountyForCaseName')->middleware('auth');
Route::get('calculations/actual-сase-data', 'CalculatorController@getLastActualDataForCaseName')->middleware('auth');

Route::post('/checkout', 'CheckoutController@create')->middleware('auth');

Route::post('/investor/apply', 'InvestorController@apply')->middleware('auth');

Route::put('/profile', 'ProfileController@update')->middleware('auth');;

Route::middleware(['auth', 'role:admin'])->prefix('dashboard')->group(function () {
    Route::get('/deadline-rule/{id}', 'Dashboard\DeadlineRulesController@getEditDeadlineData');
    Route::patch('/deadline-rule/{id}', 'Dashboard\DeadlineRulesController@updateDeadline');
    Route::delete('/deadline-rule/{id}', 'Dashboard\DeadlineRulesController@delete');
    Route::post('/deadline-rule', 'Dashboard\DeadlineRulesController@createDeadline');
    Route::get('/requests/{id}', 'Dashboard\RequestsController@get');
    Route::patch('/requests/{id}', 'Dashboard\RequestsController@update');
    Route::post('/document', 'Dashboard\DocumentTypesController@create');
    Route::patch('/document/{id}', 'Dashboard\DocumentTypesController@update');
    Route::delete('/document/{id}', 'Dashboard\DocumentTypesController@delete');
    Route::post('/delivery-method', 'Dashboard\DeliveryMethodController@create');
    Route::patch('/delivery-method/{id}', 'Dashboard\DeliveryMethodController@update');
    Route::delete('/delivery-method/{id}', 'Dashboard\DeliveryMethodController@delete');
});
