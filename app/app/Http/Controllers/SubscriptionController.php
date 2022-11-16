<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class SubscriptionController extends Controller
{
    public function index()
    { 
        echo "i am in subscription controller";
        die;
        $user = Auth::guard()->user();

        return view('profile.subscription', compact('user'));
    }
}
