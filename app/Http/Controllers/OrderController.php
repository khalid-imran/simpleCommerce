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

class OrderController extends Controller
{
    public function addOrder(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'name' => 'required',
            'address' => 'required',
            'delivery_charge' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $userId = null;
        $userInfo = $request->user('api');
        if ($userInfo != null) {
            $userId = $userInfo->id;
        }
        if (isset($input['guest_user_id']) && !empty($input['guest_user_id'])) {
            $userId = $input['guest_user_id'];
            $guest = Guest::where('uid', $userId)->first();
            if (empty($guest->name)) {
                $guest->name = $input['name'];
            }
            if (empty($guest->phone)) {
                $guest->phone = $input['phone'];
            }
            if (empty($guest->address)) {
                $guest->address = $input['address'];
            }
            $guest->save();
        }
        if ($userId == null) {
            return response()->json(['status' => 500, 'message' => 'Invalid Request']);
        }
        $user = User::find($userId);
        if (empty($user->address)) {
            $user->address = $input['address'];
            $user->save();
        }

        $orderModel = new Order();
        $last_order = Order::latest('id')->first();
        if ($last_order == null) {
            $order_number = 'DV100001';
        } else {
            $last_order_number = $last_order->order_number;
            $numbers = preg_replace('/[^0-9]/', '', $last_order_number);
            $increaseNumber = $numbers + 1;
            $order_number = 'DV'. $increaseNumber;
        }


        $orderModel->user_id = $userId;
        $orderModel->order_number = $order_number;
        $orderModel->user_phone = $input['phone'];
        $orderModel->delivery_address = $input['address'];
        $orderModel->save();
        $orderId = $orderModel->id;

        if ($orderId > 0) {
            $orderItems = Cart::where('user_id', $userId)->get();
            $items = [];
            $sub_total = 0;
            foreach ($orderItems as $item) {
                $items[] = [
                    'order_id' => $orderModel->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total_price' => $item->total,
                ];
                $sub_total = $sub_total + $item->total;
            }

            OrderItem::insert($items);
            $orderModel->sub_total = $sub_total;
            $orderModel->delivery_charge = $input['delivery_charge'];
            $total = $sub_total + $input['delivery_charge'];
            $orderModel->total = $total;
            $orderModel->save();
            Cart::where('user_id', $userId)->delete();
        }
        return response()->json(['status' => 200, 'message' => 'Order Successful.']);
    }

}
