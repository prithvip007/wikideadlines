<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\DeliveryMethod;
use App\Http\Controllers\Controller;

class DeliveryMethodController extends Controller
{
    public function index(Request $request)
    {
        $id = (int) $request->id;

        $deliveryMethod = DeliveryMethod::findOrFail($id);

        return view('dashboard.pages.delivery-method', [ 'deliveryMethod' => $deliveryMethod ]);
    }

    public function all(Request $request)
    {
        $this->validatePagination();
        $deliveryMethods = DeliveryMethod::orderByDesc('id')->paginate($request->per_page);

        $ddeliveryMethodsCount = DeliveryMethod::count();

        return view('dashboard.pages.delivery-methods', [
            'deliveryMethods' => $deliveryMethods,
            'ddeliveryMethodsCount' => $ddeliveryMethodsCount
        ]);
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:4000',
            'description' => 'nullable|string|max:300',
            'warning' => 'nullable|string|max:700',
            'days' => 'required|integer|min:0|max:32767',
            'outside_state_days' => 'nullable|integer|min:-32768|max:32767',
            'outside_country_days' => 'nullable|integer|min:-32768|max:32767',
            'days_type' => 'string|in:court,calendar',
        ];

        $this->validate($request, $rules);

        $deliveryMethod = new DeliveryMethod();

        foreach ($rules as $key => $value) {
            if ($request->has($key)) {
                $deliveryMethod->{$key} = $request->{$key};
            }
        }

        $deliveryMethod->save();

        return response()->json([
            'deliveryMethod' => $deliveryMethod->toArray()
        ]);
    }

    public function update(Request $request)
    {    
        $deliveryMethodId = $request->id;
        $deliveryMethod = DeliveryMethod::findOrFail($deliveryMethodId);

        $rules = [
            'name' => 'string|max:4000',
            'description' => 'nullable|string|max:300',
            'warning' => 'nullable|string|max:700',
            'days' => 'integer|min:0|max:32767',
            'outside_state_days' => 'nullable|integer|min:-32768|max:32767',
            'outside_country_days' => 'nullable|integer|min:-32768|max:32767',
            'days_type' => 'string|in:court,calendar',
        ];

        $this->validate($request, $rules);

        foreach ($rules as $key => $value) {
            if ($request->has($key)) {
                $deliveryMethod->{$key} = $request->{$key};
            }
        }

        $deliveryMethod->save();

        return response()->json([
            'deliveryMethod' => $deliveryMethod->toArray()
        ]);
    }

    public function delete(Request $request) {
        $id = (int) $request->id;

        $deliveryMethod = DeliveryMethod::findOrFail($id);

        $deliveryMethod->delete();

        return response()->json([
            'redirect_to' => route('dashboard.delivery-methods')
        ]);
    }
}
