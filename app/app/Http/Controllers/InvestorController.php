<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\InvestorApplication as InvestorApplicationEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\InvestorApplication;
use App\Models\User;

use Auth;
use Exception;

class InvestorController extends Controller
{
    public function index()
    {
        return view('profile.investor');
    }

    public function apply(Request $request)
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255'
        ];

        $this->validate($request, $rules);

        $user = Auth::user();

        if (InvestorApplication::canUserApply($user) === false) {
            throw new Exception("Can't apply to become an investor");
        }

        $investorApplication = new InvestorApplication();

        $investorApplication->first_name = $request->first_name;
        $investorApplication->last_name = $request->last_name;
        $investorApplication->email = $request->email;
        $investorApplication->user_id = $user->id;

        $investorApplication->save();

        User::whereRoleIs('owner')->get()->each(function ($user) use ($investorApplication) {
            if (sizeof($user->notification_emails) === 0) {
                return;
            }

            $investorApplicationEmail = new InvestorApplicationEmail($investorApplication, $user);

            Mail::to($user->notification_emails)->queue($investorApplicationEmail); 
        }, []);

        return response()->json([
            'data' => [
                'delay_days' => InvestorApplication::getLeftDelayDaysForUser($user)
            ]
        ]);
    }
}
