<?php

namespace App\Http\Controllers;

use App\Models\Calculation\Calculation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::guard()->user();

        $hasSubscription = $user->subscribed();;

        $authedUserId = Auth::id();

        $calculations = [];
        $results = [];

        if ($hasSubscription) {
            $calculations = Calculation::select('case_name')
                ->groupby('case_name')
                ->distinct()
                ->where('user_id', $authedUserId)
                ->where('case_name', '!=', null)
                ->orderBy('case_name')
                ->paginate(5);
            
            $results = $calculations->map(function ($item) {
                return [
                    'case_name' => $item->case_name,
                    'all_count' => Calculation::where('case_name', $item->case_name)->count(),
                    'add_calculation_url' => route('calculate', [ 'case_name' => $item->case_name ])
                ];
            });
        }

        return view('history.index', [ 'calculations' => $calculations, 'results' => $results, 'hasSubscription' => $hasSubscription ]);
    }
}
