<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
        $inputData = $request->all();
        $validator = Validator::make($inputData, [
            'name' => 'required',
            'phone' => 'required|numeric|unique:users|digits:11',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $phone = substr($inputData['phone'], 0, -8);
        if ($phone != '017' && $phone != '018' && $phone != '019' && $phone != '013' && $phone != '014' && $phone != '016' && $phone != '015') {
            return response()->json(['status' => 500, 'errors' => ['phone' => ['Please insert a valid Bangladeshi number']]], 200);
        }
        $user = new User();
        $user->name = $inputData['name'];
        $user->phone = $inputData['phone'];
        $user->password =  bcrypt($inputData['password']);
        $user->save();
        if (isset($inputData['guest_user_id'])) {
            $carts = Cart::where('user_id', $inputData['guest_user_id'])->get()->toArray();
            foreach ($carts as $cart) {
                $cartCheck = Cart::where('user_id', $user->id)->where('product_id', $cart['product_id'])->first();
                if ($cartCheck != null) {
                    $cartCheck->quantity = $cartCheck->quantity + $cart['quantity'];
                    $cartCheck->save();
                } else {
                    $cartModel = new Cart();
                    $cartModel->user_id = $user->id;
                    $cartModel->product_id = $cart['product_id'];
                    $cartModel->quantity = $cart['quantity'];
                    $cartModel->price = $cart['price'];
                    $cartModel->total = $cart['total'];
                    $cartModel->product_variant_id = $cart['product_variant_id'];
                    $cartModel->save();
                }
            }
            Cart::where('user_id', $inputData['guest_user_id'])->delete();
        }
        $access_token = $user->createToken('authToken')->accessToken;
        return response()->json(['status' => 200, 'access_token' => $access_token, 'user' => User::parseData($user)]);
    }

    public function login(Request $request)
    {
        $inputData = $request->all();
        $validator = Validator::make($inputData, [
            'phone' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $userInfo = User::where('phone', $inputData['phone'])->first();
        if($userInfo == null){
            return response()->json(['status' => 500, 'errors' => ['phone' => ['Invalid credential! Please try again']]], 200);
        }
        if (Hash::check($inputData['password'], $userInfo->password)) {
            if (isset($inputData['is_admin']) && $inputData['is_admin'] == 1) {
                if ($userInfo->is_admin == 1) {
                    $access_token = $userInfo->createToken('authToken')->accessToken;
                    return response()->json(['status' => 200,'access_token' => $access_token, 'user' => User::parseData($userInfo)]);
                }
                return response()->json(['status' => 500, 'errors' => ['password' => ['You are not an admin.']]], 200);
            }
            $access_token = $userInfo->createToken('authToken')->accessToken;
            return response()->json(['status' => 200,'access_token' => $access_token, 'user' => User::parseData($userInfo)]);
        }
        return response()->json(['status' => 500, 'errors' => ['password' => ['Password is not correct! Please try again.']]], 200);
    }
    public function loginUser(Request $request)
    {
        $inputData = $request->all();
        $validator = Validator::make($inputData, [
            'phone' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $userInfo = User::where('phone', $inputData['phone'])->first();
        if($userInfo == null){
            return response()->json(['status' => 500, 'errors' => ['phone' => ['Invalid credential! Please try again']]], 200);
        }
        if (Hash::check($inputData['password'], $userInfo->password)) {
            if (isset($inputData['guest_user_id'])) {
                $carts = Cart::where('user_id', $inputData['guest_user_id'])->get()->toArray();
                foreach ($carts as $cart) {
                    $cartCheck = Cart::where('user_id', $userInfo->id)->where('product_id', $cart['product_id'])->first();
                    if ($cartCheck != null) {
                        $cartCheck->quantity = $cartCheck->quantity + $cart['quantity'];
                        $cartCheck->save();
                    } else {
                        $cartModel = new Cart();
                        $cartModel->user_id = $userInfo->id;
                        $cartModel->product_id = $cart['product_id'];
                        $cartModel->quantity = $cart['quantity'];
                        $cartModel->price = $cart['price'];
                        $cartModel->total = $cart['total'];
                        $cartModel->product_variant_id = $cart['product_variant_id'];
                        $cartModel->save();
                    }
                }
                Cart::where('user_id', $inputData['guest_user_id'])->delete();
            }
            $access_token = $userInfo->createToken('authToken')->accessToken;
            return response()->json(['status' => 200,'access_token' => $access_token, 'user' => User::parseData($userInfo)]);
        }
        return response()->json(['status' => 500, 'errors' => ['password' => ['Password is not correct! Please try again.']]], 200);
    }
    public function logoutUser(Request $request)
    {
        $request->user('api')->token()->revoke();
        return response()->json(['status' => 200, 'message' => 'Logout successfully']);
    }
    public function forget(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }

        $UserInfo = User::where('phone', $input['phone'])->first();
        if ($UserInfo == null) {
            return response()->json(['status' => 500, 'errors' => ['phone' => ['Phone is not exist in our database.']]], 200);
        } else {
//            Mail::send('email.forgot', ['userInfo' => $UserInfo], function ($message) use ($UserInfo) {
//                $message->to($UserInfo['email'], $UserInfo['name'])->subject(env('APP_NAME') . ': Password Reset Code');
//                $message->from('no-reply@moddhobritto.com', env('APP_NAME'));
//            });
        }

    }

    public function passwordReset(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'phone' => 'required',
            'code' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $userInfo = User::where('reset_code', $input['code'])
            ->where(function($q) use ($input) {
                $q->where('phone', $input['phone']);
            })
            ->first();
        if ($userInfo == null) {
            return response()->json(['status' => 500, 'errors' => ['code' => ['Invalid Request. Please check your reset code please.']]], 200);
        }

        $userInfo->reset_code = null;
        $userInfo->password = bcrypt($input['password']);
        $userInfo->save();
        return response()->json(['status' => 200, 'msg' => 'Password reset successful'], 200);
    }
    public function profile(Request $request)
    {
        $userInfo = $request->user('api');
        if ($userInfo != null) {
            return response()->json(['status' => 200, 'user' => User::parseData($userInfo)]);
        }
        return response()->json(['status' => 500, 'message' => 'Invalid Request'], 200);
    }
}
