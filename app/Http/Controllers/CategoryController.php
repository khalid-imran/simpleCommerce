<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function save(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required|string|unique:categories,name'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $slug = Str::slug($requestData['name']);
        $checkSlug = Category::where('slug', $slug)->first();
        if ($checkSlug != null) {
            $slug = $slug . '-' . time();
        }

        $category = new Category();
        $category->name = $requestData['name'];
        $category->slug = $slug;
        if ($category->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully saved category.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot saved category.']);
    }
    public function list(Request $request)
    {
        $requestData = $request->all();
        $limit = isset($requestData['limit']) && !empty($requestData['limit']) ? $requestData['limit'] : 10;
        $orderBy = isset($requestData['order_by']) && !empty($requestData['order_by']) ? $requestData['order_by'] : 'id';
        $orderMode = isset($requestData['order_mode']) && !empty($requestData['order_mode']) ? $requestData['order_mode'] : 'DESC';
        $keyword = isset($requestData['keyword']) ? $requestData['keyword'] : '';
        $result = Category::select('id', 'name');
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
        $result = Category::find($requestData['id']);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function update(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }

        $category = Category::where('name', $requestData['name'])->where('id', '!=', $requestData['id'])->first();
        if ($category != null) {
            return response()->json(['status' => 500, 'errors' => ['name' => ['The name filed already have been taken.']]]);
        }
        $category = Category::find($requestData['id']);
        if ($category == null) {
            return response()->json(['status' => 500, 'message' => 'Cannot find category.']);
        }
        $slug = Str::slug($requestData['name']);
        $checkSlug = $category['slug'];
        if ($checkSlug == $slug) {
            $slug = $slug . '-' . time();
        }

        $category->name = $requestData['name'];
        $category->slug = $slug;
        if ($category->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully updated category.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot updated category.']);
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
        Category::where('id', $requestData['id'])->delete();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted category.']);
    }
}
