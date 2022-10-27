<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $user = Auth::guard()->user();

        $isFacebookConnectedInitial = $user->facebook_id !== null;
        $isGoogleConnectedInitial = $user->google_id !== null;

        return view('profile.services', [
            'isFacebookConnectedInitial' => $isFacebookConnectedInitial,
            'isGoogleConnectedInitial' => $isGoogleConnectedInitial
        ]);
    }
}
