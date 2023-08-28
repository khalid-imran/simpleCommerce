<?php

namespace App\Http\Controllers;
;

use App\Models\City;
use App\Models\DeliveryFee;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryFeeFrontController extends Controller
{
    public function list(Request $request)
    {
        $result = DeliveryFee::select('id', 'name', 'fee')->get()->toArray();
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function getState(Request $request)
    {
        $result = State::select('id', 'name')->get()->toArray();
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function getCity(Request $request)
    {
        $requestData = $request->all();
        $state = isset($requestData['state_id']) ? $requestData['state_id'] : '';
        $result = City::select('id', 'name', 'cost', 'state_id');
        if (!empty($state)) {
            $result->where(function($q) use ($state) {
                $q->where('state_id', '=', $state);
            });
        }
        $result = $result->get()->toArray();
        return response()->json(['status' => 200, 'data' => $result]);
    }

}
