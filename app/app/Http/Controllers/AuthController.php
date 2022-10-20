<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Support\Facades\Auth;
use App\Rules\PhoneNumber;
use App\Verify\Service;
use Illuminate\Validation\ValidationException;
use  App\UserTokenAuth;


// TODO: ADD LOGIN THROTTLING
class AuthController extends Controller
{
    protected function getPhoneValidationRules() {
        return ['required', new PhoneNumber, 'min:2', 'max:15'];
    }

    public function index(Request $request)
    {
        $step = (int) $request->query('step');

        // allow only step №2 right now
        if ($step !== 2) {
            $step = 0;
        }

        $isSignup = $request->route()->named('signup');

        return view('authentication.index', ['step' => $step, 'isSignup' => $isSignup]);
    }

    public function sendCode(Request $request, Service $verify)
    {
        $rules = ['phone_number' => $this->getPhoneValidationRules()];
       
        $this->validate($request, $rules, [
            'phone_number.max' => __('validation.max.phone'),
            'phone_number.min' => __('validation.min.phone'),
            'phone_number.required' => __('validation.phone.required')
        ]);

        $verification = $verify->startVerification($request->input('phone_number'), 'sms');

        if ($verification->isValid() === false) {
            throw ValidationException::withMessages(['phone_number' => $verification->getErrors()]);
        }
    }

    public function confirmCode(Request $request, Service $verify)
    {
        $phoneNumber = $request->input('phone_number');
        $code = $request->input('sms_code');

        $verification = $verify->checkVerification($phoneNumber, $code);

        if ($verification->isValid() === false) {
            throw ValidationException::withMessages(['sms_code' => $verification->getErrors()]);
        }

        $user = User::firstOrCreate([
            'phone_number' => $request->input('phone_number')
        ]);

        // // refresh to fetch default values from database
        $user->refresh();

        $guard = Auth::guard();

        $guard->login($user);

        return response()->json([
            'data' => [
                'redirect_to' => request()->headers->get('referer'),
                'is_registered' => $user->wasRecentlyCreated,
                'user' => $user->toArray()
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $guard = Auth::guard();

        $guard->logoutCurrentDevice();

        return redirect()->route('calculate');
    }

    public function emailAuthentication(Request $request)
    {
        $isSignup = $request->route()->named('singup.email');

        return view('authentication.email', [ 'isSignup' => $isSignup ]);
    }

    public function sendEmailCode(Request $request)
    {
        $rules = ['email' => 'email'];
        // $rules = ['email' => 'email|unique:users'];

        $this->validate($request, $rules);

        // Verification::startVerification($request->input('email'));
    }

    public function confirmEmailCode(Request $request)
    {
        $rules = [
            'email' => 'email',
            'code' => 'string'
        ];

        $this->validate($request, $rules);

        // $isValid = Verification::verify($request->input('email'), $request->input('code'));

        // if ($isValid === false) {
        //     throw ValidationException::withMessages(['code' => 'Code is not valid']);
        // }

        $user = User::firstOrCreate([
            'email' => $request->input('email')
        ]);

        // // refresh to fetch default values from database
        $user->refresh();

        $guard = Auth::guard();

        $guard->login($user);

        return response()->json([
            'data' => [
                'redirect_to' => request()->headers->get('referer'),
                'user' => $user->toArray()
            ]
        ]);
    }

    public function profile() {
        return view('authentication.profile');
    }

    public function authenticateByLink(Request $request)
    {
        UserTokenAuth::authenticateByToken($request->jwt);

        return redirect($request->redirectURL ?? route('home'));
    }
}
