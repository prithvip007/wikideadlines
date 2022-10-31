<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Request as RequestModel;

class FeedbackController extends Controller
{
    public function all(Request $request)
    {
        $this->validatePagination();
        $requests = RequestModel::whereIn('type', ['feedback'])->orderByDesc('id')->paginate($request->per_page);

        $requestsCount = RequestModel::whereIn('type', ['feedback'])->count();

        return view('dashboard.pages.feedbacks', [
            'requests' => $requests,
            'requestsCount' => $requestsCount
        ]);
    }

    public function index(Request $request)
    {
        $id = (int) $request->id;

        $request = RequestModel::whereIn('type', ['feedback'])->findOrFail($id);

        return view('dashboard.pages.feedback', [ 'request' => $request ]);
    }
}
