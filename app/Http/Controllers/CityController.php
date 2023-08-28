<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function save(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required',
            'state_id' => 'required',
            'cost' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $city = new City();
        $city->name = $requestData['name'];
        $city->state_id = $requestData['state_id'];
        $city->cost = $requestData['cost'];
        if ($city->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully saved city.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot saved city.']);
    }
    public function list(Request $request)
    {
        $requestData = $request->all();
        $limit = isset($requestData['limit']) && !empty($requestData['limit']) ? $requestData['limit'] : 10;
        $orderBy = isset($requestData['order_by']) && !empty($requestData['order_by']) ? $requestData['order_by'] : 'id';
        $orderMode = isset($requestData['order_mode']) && !empty($requestData['order_mode']) ? $requestData['order_mode'] : 'DESC';
        $keyword = isset($requestData['keyword']) ? $requestData['keyword'] : '';
        $state = isset($requestData['state_id']) ? $requestData['state_id'] : '';
        $result = City::select('id', 'name', 'state_id', 'cost')->with('state');
        if (!empty($keyword)) {
            $result->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', '%'.$keyword.'%');
            });
        }
        if (!empty($state)) {
            $result->where(function($q) use ($state) {
                $q->where('state_id', '=', $state);
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
        $result = City::find($requestData['id']);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function update(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
            'name' => 'required',
            'state_id' => 'required',
            'cost' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $city = City::find($requestData['id']);
        if ($city == null) {
            return response()->json(['status' => 500, 'message' => 'Cannot find city.']);
        }
        $city->name = $requestData['name'];
        $city->state_id = $requestData['state_id'];
        $city->cost = $requestData['cost'];
        if ($city->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully updated city.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot updated city.']);
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
        City::where('id', $requestData['id'])->delete();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted city.']);
    }
}
