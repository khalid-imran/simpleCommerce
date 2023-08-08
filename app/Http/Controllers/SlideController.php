<?php

namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SlideController extends Controller
{
    public function save(Request $request)
{
    $requestData = $request->all();
    $validator = Validator::make($requestData, [
        'title' => 'required',
        'button_title' => 'required',
        'file' => 'required'
    ]);
    if ($validator->fails()) {
        return response()->json(['status' => 500, 'errors' => $validator->errors()]);
    }
    $image_path = null;
    if ($request->file('file')) {
        $image = $request->file('file');
        $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $image->getClientOriginalName());
        $image->move(storage_path('/app/public/uploads'), $name);
        $image_path = $name;
    }
    $slide = new Slide();
    $slide->title = $requestData['title'];
    $slide->button_title = $requestData['button_title'];
    $slide->file_path = $image_path;
    if ($slide->save()) {
        return response()->json(['status' => 200, 'message' => 'Successfully saved slide.']);
    }
    return response()->json(['status' => 500, 'message' => 'Cannot saved slide.']);
}
    public function list(Request $request)
    {
        $requestData = $request->all();
        $limit = isset($requestData['limit']) && !empty($requestData['limit']) ? $requestData['limit'] : 10;
        $orderBy = isset($requestData['order_by']) && !empty($requestData['order_by']) ? $requestData['order_by'] : 'id';
        $orderMode = isset($requestData['order_mode']) && !empty($requestData['order_mode']) ? $requestData['order_mode'] : 'DESC';
        $keyword = isset($requestData['keyword']) ? $requestData['keyword'] : '';
        $result = Slide::select('id', 'title', 'button_title', 'file_path');
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
        $result = Slide::find($requestData['id']);
        return response()->json(['status' => 200, 'data' => $result]);
    }
    public function update(Request $request)
    {
        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
            'title' => 'required',
            'button_title' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 500, 'errors' => $validator->errors()]);
        }
        $slide = Slide::find($requestData['id']);
        if ($slide == null) {
            return response()->json(['status' => 500, 'message' => 'Cannot find slide.']);
        }
        $image_path = $slide->file_path;
        if ($request->file('file')) {
            $image = $request->file('file');
            if ($image) {
                $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $image->getClientOriginalName());
                $image->move(storage_path('/app/public/uploads'), $name);
                $image_path = $name;
                if (!empty($slide->file_path) && file_exists(public_path('storage/uploads/'.$slide->file_path))) {
                    unlink(public_path('storage/uploads/'.$slide->file_path));
                }
            }

        }
        $slide->title = $requestData['title'];
        $slide->button_title = $requestData['button_title'];
        $slide->file_path = $image_path;
        if ($slide->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully updated slide.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot updated slide.']);
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
        $slide = Slide::find($requestData['id']);
        if (!empty($slide->file_path) && file_exists(public_path('storage/uploads/'.$slide->file_path))) {
            unlink(public_path('storage/uploads/'.$slide->file_path));
        }
        $slide->delete();
        return response()->json(['status' => 200, 'message' => 'Successfully deleted slide.']);
    }
}
