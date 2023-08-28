<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductFrontController extends Controller
{
    public function latest(Request $request)
    {
        $result = Product::with('images', 'variants')->where('upcoming', 0);
        $result = $result->orderBy('id', 'DESC')
            ->skip(0)->take(6)->get()->toArray();
        foreach ($result as &$product) {
            $product['loading'] = false;
        }
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function tranding(Request $request)
    {
        $result = Product::with('images', 'variants')->where('tranding', 1);
        $result = $result->orderBy('id', 'DESC')
            ->skip(0)->take(6)->get()->toArray();
        foreach ($result as &$product) {
            $product['loading'] = false;
        }
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function upcoming(Request $request)
    {
        $result = Product::with('images', 'variants')->where('upcoming', 1);
        $result = $result->orderBy('id', 'DESC')
            ->skip(0)->take(6)->get()->toArray();
        foreach ($result as &$product) {
            $product['loading'] = false;
        }
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function byCategory(Request $request)
    {
        $requestData = $request->all();
        $category_id = Category::select('id')->where('slug', $requestData['slug'])->first();
        $result = Product::with('images', 'variants')
            ->where('category_id', $category_id['id'])
            ->orderBy('id', 'DESC')
            ->get()->toArray();
        foreach ($result as &$product) {
            $product['loading'] = false;
        }
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function getAll(Request $request)
    {
        $result = Product::with('images', 'variants')->where('upcoming', 0);
        $result = $result->orderBy('id', 'DESC')
           ->get()->toArray();
        foreach ($result as &$product) {
            $product['loading'] = false;
        }
        return response()->json(['status' => 200, 'data' => $result]);
    }

    public function getSingle(Request $request)
    {
        $requestData = $request->all();
        $result = Product::with('images', 'variants')
            ->where('slug', $requestData['slug'])
            ->first();
        return response()->json(['status' => 200, 'data' => $result]);
    }
}
