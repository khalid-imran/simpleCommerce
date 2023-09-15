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
            'state_id' => 'required',
            'city_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $phone = substr($input['phone'], 0, -8);
        if ($phone != '017' && $phone != '018' && $phone != '019' && $phone != '013' && $phone != '014' && $phone != '016' && $phone != '015') {
            return response()->json(['status' => 500, 'errors' => ['phone' => ['Please insert a valid Bangladeshi number']]], 200);
        }
        $userId = null;
        $userInfo = $request->user('api');
        if ($userInfo != null) {
            $userId = $userInfo->id;
            $user = User::find($userId);
            if (empty($userInfo->address)) {
                $user->address = $input['address'];
                $user->save();
            }
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
        $orderModel->state_id = $input['state_id'];
        $orderModel->city_id = $input['city_id'];
        $orderModel->save();
        $orderId = $orderModel->id;

        if ($orderId > 0) {
            $orderItems = Cart::where('user_id', $userId)->get();
            $items = [];
            $sub_total = 0;
            $discount_sub_total = 0;
            foreach ($orderItems as $item) {
                $product = Product::select('discount_type', 'discount_amount', 'id')->where('id', $item->product_id)->first();
                $variant = ProductVariants::select('price', 'id')->where('id', $item->product_variant_id)->first();
                if ($product->discount_type == 0) {
                    $discount_price = $variant->price - $product->discount_amount;
                    $discount_total = $discount_price * $item->quantity;
                } else if ($product->discount_type == 1) {
                    $discount_price = $variant->price - (($product->discount_amount / 100) * $variant->price);
                    $discount_total = $discount_price * $item->quantity;
                } else {
                    $discount_price = $item->price;
                    $discount_total = $item->total;
                }
                $items[] = [
                    'order_id' => $orderModel->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                    'total_price' => $item->total,
                ];
                $sub_total = $sub_total + $item->total;
                $discount_sub_total = $discount_sub_total + $discount_total;
            }

            OrderItem::insert($items);
            $orderModel->sub_total = $sub_total;
            $orderModel->discount_sub_total = $discount_sub_total;
            $orderModel->delivery_charge = $input['delivery_charge'];
            $total = $discount_sub_total + $input['delivery_charge'];
            $orderModel->total = $total;
            $orderModel->save();
            Cart::where('user_id', $userId)->delete();
        }
        return response()->json(['status' => 200, 'message' => 'Order Successful.']);
    }
    public function getOrder(Request $request)
    {
        $input = $request->input();
        $userInfo = $request->user('api');
        $orders = Order::with('user', 'state', 'city')->where('orders.user_id', $userInfo->id);
        if (!empty($input['status'])) {
            $orders->where('orders.status', $input['status']);
        }
        $orders = $orders->orderBy('id', 'DESC')->get()->toArray();
        return response()->json(['status' => 200, 'data' => $orders]);
    }
    public function cancelOrder(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'order_id' => 'required',
        ]);
        if ($validator->fails()) {
            return ['status' => 5000, 'error' => $validator->errors()];
        }
        $order = Order::where('id', $input['order_id'])->first();

        if ($order->status == 'pending') {
            $order->update([
                'status' => 'cancel'
            ]);
            return response()->json(['status' => 200, 'data' => $order]);
        }
        return response()->json(['status' => 500, 'message' => 'You cannot cancel this order in this moment, Product is already on the way']);
    }
    public function getOrderGuest(Request $request)
    {
        $input = $request->input();
        $orders = Order::with('guest', 'state', 'city')->where('orders.user_id', $input['guest_user_id']);
        if (!empty($input['status'])) {
            $orders->where('orders.status', $input['status']);
        }
        $orders = $orders->orderBy('id', 'DESC')->get()->toArray();
        return response()->json(['status' => 200, 'data' => $orders]);
    }
}
