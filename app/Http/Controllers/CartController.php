<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'product_id' => 'required',
            'variant_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $userInfo = $request->get('sessionUser');
        $userId = '';
        if ($userInfo != null) {
            $userId = $userInfo->id;
        }
        if (isset($input['guest_user_id']) && !empty($input['guest_user_id'])) {
            $userId = $input['guest_user_id'];
        }

        $price = ProductVariants::select('variants.price')->where('product_id', $input['product_id'])->where('id', $input['variant_id'])->first();
        $checkExist = Cart::where('product_id', $input['product_id'])->where('product_variant_id', $input['variant_id'])->where('user_id', $userId)->first();

        if ($checkExist != null) {
            $quantity = isset($input['quantity']) && $input['quantity'] != '' ? $input['quantity'] : 1;
            $quantity = $quantity + $checkExist->quantity;
            $total = $quantity * $price->price;
            if ($quantity < 1) {
                Cart::where('product_id', $input['product_id'])->where('product_variant_id', $input['variant_id'])->where('user_id', $userId)->delete();
                return response()->json(['status' => 200, 'message' => 'Cart deleted successfully.']);
            }
            Cart::where('product_id', $input['product_id'])->where('product_variant_id', $input['variant_id'])->where('user_id', $userId)->update([
                "quantity" => $quantity,
                "total" => $total,
            ]);
            return response()->json(['status' => 200, 'message' => 'Cart Successful.']);
        }
        $quantity = isset($input['quantity']) && $input['quantity'] != '' ? $input['quantity'] : 1;
        if ($quantity < 1) {
            return response()->json(['status' => 500, 'message' => 'invalid quantity.']);
        }

        $total = $price->price * $quantity;
        $cartModel = new Cart();
        $cartModel->user_id = $userId;
        $cartModel->product_id = $input['product_id'];
        $cartModel->product_variant_id = $input['variant_id'];
        $cartModel->quantity = $quantity;
        $cartModel->price = $price->price;
        $cartModel->total = $total;
        $cartModel->save();
        return response()->json(['status' => 200, 'message' => 'Cart Successful.']);
    }

    public function getCart(Request $request) {
        $input = $request->input();
        $userId = isset($input['guest_user_id']) ? $input['guest_user_id'] : '';
        $userInfo = $request->get('sessionUser');
        if ($userInfo != null) {
            $userId = $userInfo->id;
        }

        $productData = Product::with('images');
        $productData = $productData->select('products.id', 'products.title', 'products.features', 'products.slug', 'products.discount_type',
            'carts.price as sell_price', 'products.discount_amount', 'carts.quantity as cart_quantity', 'variants.title as variant_title', 'variants.id as variant_id');
        $productData = $productData->leftJoin('carts', 'carts.product_id', '=', 'products.id');
        $productData = $productData->leftJoin('variants', 'variants.id', '=', 'carts.product_variant_id');
        $productData = $productData->where('carts.user_id', $userId);
        $productData = $productData->distinct('products.id')->get()->toArray();

        $info = array(
            'total_products' => count($productData),
            'total_price' => 0
        );
        foreach ($productData as &$product) {
            $product['price'] = $product['discount_value'] * $product['cart_quantity'];
            $product['loading'] = false;
            $product['removeLoading'] = false;
            $info['total_price'] = $info['total_price'] + $product['price'];
        }
        return response()->json(['status' => 200, 'data' => $productData, 'info' => $info]);
    }

    public function deleteCart(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input, [
            'product_id' => 'required',
            'variant_id' => 'required',
        ]);

        if ($validator->fails()) {
            return ['status' => 5000, 'error' => $validator->errors()];
        }

        $userId = isset($input['guest_user_id']) ? $input['guest_user_id'] : '';
        $userInfo = $request->get('sessionUser');
        if ($userInfo != null) {
            $userId = $userInfo->id;
        }
        if ($userId == '') {
            return response()->json(['status' => 500, 'message' => 'Invalid Request']);
        }
        Cart::where('product_id', $input['product_id'])->where('product_variant_id', $input['variant_id'])->where('user_id', $userId)->delete();
        return response()->json(['status' => 200, 'message' => 'Removed product from cart Successful']);
    }
}
