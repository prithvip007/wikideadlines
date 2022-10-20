<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProfileCheckReverse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard()->user();

        if (!$user) {
            return $next($request);
        }

        if ($user->first_name && $user->experience_level_id) {
            return redirect(
                route('home')
            );
        }

        return $next($request);
    }
}
