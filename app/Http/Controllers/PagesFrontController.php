<?php

namespace App\Http\Controllers;

use App\Models\pages;
use Illuminate\Http\Request;

class PagesFrontController extends Controller
{
    public function getPageSingle(Request $request)
    {
        $requestData = $request->all();
        $result = pages::where('slug', $requestData['slug'])->first();
        return response()->json(['status' => 200, 'data' => $result]);
    }
}
