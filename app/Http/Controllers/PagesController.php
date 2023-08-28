<?php

namespace App\Http\Controllers;

use App\Models\pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function save(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $slug = Str::slug($requestData['name']);
        $checkSlug = pages::where('slug', $slug)->first();
        if ($checkSlug != null) {
            $slug = $slug . '-' . time();
        }

        $pages = new pages();
        $pages->name = $requestData['name'];
        $pages->slug = $slug;
        $pages->content = $requestData['content'];
        if ($pages->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully saved pages.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot saved pages.']);
    }
    public function list(Request $request)
    {
        $requestData = $request->all();
        $limit = isset($requestData['limit']) && !empty($requestData['limit']) ? $requestData['limit'] : 10;
        $orderBy = isset($requestData['order_by']) && !empty($requestData['order_by']) ? $requestData['order_by'] : 'id';
        $orderMode = isset($requestData['order_mode']) && !empty($requestData['order_mode']) ? $requestData['order_mode'] : 'DESC';
        $keyword = isset($requestData['keyword']) ? $requestData['keyword'] : '';
        $result = pages::select('id', 'name');
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
        $result = pages::find($requestData['id']);
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

        $pages = pages::where('name', $requestData['name'])->where('id', '!=', $requestData['id'])->first();
        if ($pages != null) {
            return response()->json(['status' => 500, 'errors' => ['name' => ['The name filed already have been taken.']]]);
        }
        $pages = pages::find($requestData['id']);
        if ($pages == null) {
            return response()->json(['status' => 500, 'message' => 'Cannot find pages.']);
        }
        $slug = Str::slug($requestData['name']);
        $checkSlug = $pages['slug'];
        if ($checkSlug == $slug) {
            $slug = $slug . '-' . time();
        }

        $pages->name = $requestData['name'];
        $pages->slug = $slug;
        $pages->content = $requestData['content'];
        if ($pages->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully updated pages.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot updated pages.']);
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
        pages::where('id', $requestData['id'])->delete();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted pages.']);
    }
}
