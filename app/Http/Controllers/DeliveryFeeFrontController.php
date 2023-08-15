<?php

namespace App\Http\Controllers;
;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryFeeFrontController extends Controller
{
    public function list(Request $request)
    {
        $result = DeliveryFee::select('id', 'name', 'fee')->get()->toArray();
        return response()->json(['status' => 200, 'data' => $result]);
    }
}
