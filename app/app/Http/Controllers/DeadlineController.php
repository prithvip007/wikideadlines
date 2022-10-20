<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeadlineThumb;
use Illuminate\Support\Facades\Validator;
use App\Models\Deadline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class DeadlineController extends Controller
{
    public function createThumb(Request $request) {
        // TODO: fix bug
        /**
         * At this moment we allow to thumb up a deadline version one time per calculation
         * i.e. a user can thumb up the same deadline multiple times in different calculation
         * to prevent it we should add validation again it
         * this can be done the next way:
         * each thumb up has calculation_id i.e. effective date of thumb up is determined by calculation.created_at
         * by this effective date we determine a version of deadline that is thumbed up
         * before inserting a new thumb up we can check whether a dealine version is thumbed up
         * see: DeadlineThumb::getHistoricalCount
         */

        $rules = [
            'calculation_id' => 'required|exists:App\Models\Calculation\Calculation,id'
        ];

        Deadline::findOrFail($request->id);

        $this->validate($request, $rules);

        $deadlineThumb = new DeadlineThumb();

        $deadlineThumb->user_id = Auth::id();
        $deadlineThumb->deadline_id =  $request->id;
        $deadlineThumb->calculation_id = $request->calculation_id;
      
        try {
            $deadlineThumb->save();
        } catch (QueryException $e) {
            if ('23505' !== $e->getCode()) {
                throw $e;
            }
        }
    }

    public function deleteThumb(Request $request) {
        $validator = Validator::make([
            'id' => $request->id,
            'calculation_id' => $request->calculation_id
        ], [
            'id' => 'required|exists:App\Models\Deadline,id',
            'calculation_id' => 'required|exists:App\Models\Calculation\Calculation,id'
        ]);

        $validator->validate();

        DeadlineThumb::where([
            'deadline_id' => $request->id,
            'user_id' => Auth::id(),
            'calculation_id' => $request->calculation_id
        ])->delete();
    }
}
