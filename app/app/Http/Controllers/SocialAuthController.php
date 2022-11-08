<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthenticationMethodAlreadyExists;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \Illuminate\Database\QueryException;
use \Symfony\Component\HttpKernel\Exception\HttpException;
use URL;

class SocialAuthController extends Controller
{
    public function connect(Request $request)
    {
        echo "<pre>";
        print_r($request->all());
        redirect()->setIntendedUrl(request()->headers->get('referer'));

        return Socialite::driver($request->network)->stateless->redirect();
    }

    public function callback(Request $request)
    {
        $networkUser = Socialite::driver($request->network)->user();

        $user = Auth::guard()->user();
        echo "<pre>";
        print_r($request->all());
        echo "print network";
        print_r($networkUser);
        echo "print user";
        print_r($user);
        if ($user) {
            $user->{"{$request->network}_id"} = $networkUser->id;

            try {
                $user->save();
            } catch (QueryException $e) {
                if ('23505' === $e->getCode()) {
                    throw new AuthenticationMethodAlreadyExists();
                }
    
                throw $e;
            }

            return redirect()->stateless->intended();
        }

        $userWithTheSameEmail = User::where([ 'email' => $networkUser->email ])->first();

        $user = User::firstOrCreate(
            [
                "{$request->network}_id" => $networkUser->id,
            ],
            [
                'first_name' => $networkUser->name,
                'email' => $userWithTheSameEmail ? null : $networkUser->email
            ]
        );

        // refresh to fetch default values from database
        $user->refresh();

        $guard = Auth::guard();

        $guard->login($user);

        return redirect()->intended();
    }

    public function disconnect(Request $request)
    {
        $user = Auth::guard()->user();

        $property = "{$request->network}_id";

        $user->{$property} = null;

        try {
            $user->save();
        } catch (QueryException $e) {
            if ('23514' === $e->getCode()) {
                throw new HttpException(422, 'You can\'t delete the last authentication method');
            }

            throw $e;
        }
    }
}
