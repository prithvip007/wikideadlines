<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Verify\Service;
use App\Models\Verification;
use App\Rules\PhoneNumber;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected function getPhoneValidationRules() {
        return ['required', new PhoneNumber, 'unique:users', 'min:2', 'max:15'];
    }

    public function index(Request $request)
    {
        $user = Auth::guard()->user();

        $email = $user->email;
        $firstName = $user->first_name;
        $secondName = $user->second_name;
        $phoneNumber = $user->phone_number;
        $experienceLevel =  $user->experience_level_id;

        return view('profile.index', [
            'email' => $email,
            'firstName' => $firstName,
            'secondName' => $secondName,
            'phoneNumber' => $phoneNumber,
            'experienceLevel' => $experienceLevel
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'first_name' => 'required|max:255',
            'second_name' => 'nullable|max:255',
            'experience_level' => 'required|exists:App\Models\ExperienceLevel,id'
        ];

        $this->validate($request, $rules);

        $user = Auth::guard()->user();

        $user->first_name = $request->input('first_name');
        $user->second_name = $request->input('second_name');
        $user->experience_level_id = $request->input('experience_level');
  
        $user->save();
    }

    public function sendCode(Request $request, Service $verify)
    {
        $rules = ['phone_number' => $this->getPhoneValidationRules()];

        $this->validate($request, $rules);

        $verification = $verify->startVerification($request->input('phone_number'), 'sms');

        // TODO: add validation for verification

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

        $user = Auth::guard()->user();

        $user->phone_number = $phoneNumber;

        $user->save();
    }

    public function sendEmailCode(Request $request)
    {
        $rules = ['email' => 'email|unique:users'];

        $this->validate($request, $rules);

        Verification::startVerification($request->input('email'));
    }

    public function confirmEmailCode(Request $request)
    {
        $rules = [
            'email' => 'email|unique:users',
            'code' => 'string'
        ];

        $this->validate($request, $rules);

        $isValid = Verification::verify($request->input('email'), $request->input('code'));

        if ($isValid === false) {
            throw ValidationException::withMessages(['code' => 'Code is not valid']);
        }

        $user = Auth::guard()->user();

        $user->email = $request->input('email');

        $user->save();
    }
}
