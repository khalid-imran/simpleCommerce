<?php

namespace App\Http\Controllers;
;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryFeeController extends Controller
{
    public function save(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required|string|unique:delivery_fees,name',
            'fee' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $delivery = new DeliveryFee();
        $delivery->name = $requestData['name'];
        $delivery->fee = $requestData['fee'];
        if ($delivery->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully saved Delivery Fee.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot saved Delivery Fee.']);
    }
    public function list(Request $request)
    {
        $requestData = $request->all();
        $limit = isset($requestData['limit']) && !empty($requestData['limit']) ? $requestData['limit'] : 10;
        $orderBy = isset($requestData['order_by']) && !empty($requestData['order_by']) ? $requestData['order_by'] : 'id';
        $orderMode = isset($requestData['order_mode']) && !empty($requestData['order_mode']) ? $requestData['order_mode'] : 'DESC';
        $keyword = isset($requestData['keyword']) ? $requestData['keyword'] : '';
        $result = DeliveryFee::select('id', 'name', 'fee');
        if (!empty($keyword)) {
            $result->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', '%'.$keyword.'%');
            });
        }
        $result = $result->orderBy($orderBy, $orderMode)
            ->paginate($limit);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function single(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $result = DeliveryFee::find($requestData['id']);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function update(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
            'name' => 'required|string',
            'fee' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }

        $delivery = DeliveryFee::where('name', $requestData['name'])->where('id', '!=', $requestData['id'])->first();
        if ($delivery != null) {
            return response()->json(['status' => 500, 'errors' => ['name' => ['The name filed already have been taken.']]]);
        }
        $delivery = DeliveryFee::find($requestData['id']);
        if ($delivery == null) {
            return response()->json(['status' => 500, 'message' => 'Cannot find Delivery Fee.']);
        }
        $delivery->name = $requestData['name'];
        if ($delivery->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully updated Delivery Fee.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot updated Delivery Fee.']);
    }
    public function delete(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        DeliveryFee::where('id', $requestData['id'])->delete();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted Delivery Fee.']);
    }
}
