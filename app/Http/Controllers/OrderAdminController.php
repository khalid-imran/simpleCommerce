<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Guest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderAdminController extends Controller
{
    public function getOrder(Request $request)
    {
        $requestData = $request->all();
        $limit = isset($requestData['limit']) && !empty($requestData['limit']) ? $requestData['limit'] : 10;
        $orderBy = isset($requestData['order_by']) && !empty($requestData['order_by']) ? $requestData['order_by'] : 'id';
        $orderMode = isset($requestData['order_mode']) && !empty($requestData['order_mode']) ? $requestData['order_mode'] : 'DESC';
        $keyword = isset($requestData['keyword']) ? $requestData['keyword'] : '';
        $status = isset($requestData['status']) ? $requestData['status'] : '';
        $result = Order::with('user', 'guest', 'state', 'city');
        if (!empty($keyword)) {
            $result->where(function($q) use ($keyword) {
                $q->where('order_number', 'LIKE', '%'.$keyword.'%');
            });
        }
        if (!empty($status)) {
            $result->where(function($q) use ($status) {
                $q->where('status', '=', $status);
            });
        }
        $result = $result->orderBy($orderBy, $orderMode)
            ->paginate($limit);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function updateStatus(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return ['status' => 5000, 'error' => $validator->errors()];
        }
        $order = Order::where('id', $input['order_id'])->first();
        $order->update([
            'status' => $input['status']
        ]);
        return response()->json(['status' => 200, 'message' => 'Update Status Successfully']);
    }
    public function single(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return ['status' => 5000, 'error' => $validator->errors()];
        }
        $detail = Order::with('order_item')->where('id', $input['order_id'])->first();
        return response()->json(['status' => 200, 'data' => $detail]);
    }
}
