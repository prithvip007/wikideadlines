<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StripePlan;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $id = (int) $request->id;

        $user = User::withCount('calculations')->findOrFail($id);
        echo "<pre>";
        print_r($user->roles);
        exit("fnkj");
        return view('dashboard.pages.user', [ 'user' => $user ]);
    }

    public function all(Request $request)
    {
        $this->validatePagination();
        $users = User::orderByDesc('id')->paginate($request->per_page);

        $usersCount = User::count();

        return view('dashboard.pages.users', [ 'users' => $users , 'usersCount' => $usersCount ]);
    }
}
