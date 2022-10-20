<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Calculation\Calculation;

class CheckCalculationAccessable
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
        // $user = Auth::guard()->user();

        // if (!$user->subscribed()) {
        //     abort(403, 'Subscription required');
        // }

        $key = $request->key;

        $calculation = Calculation::where('key', $key)->first();

        if (!$calculation) {
            $this->abortRequest();

            return;
        }

        if ($calculation->accessable === false) {
            $this->abortRequest();

            return;
        }

        return $next($request);
    }

    private function abortRequest() {
        abort(403, 'Subscription required');
    }
}
