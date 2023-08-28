<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeliveryFee;
use App\Models\pages;
use App\Models\Slide;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteSettingController extends Controller
{
    public function get(Request $request)
    {
        $category = Category::select('id','name', 'slug')->get()->toArray();
        $website = Website::first();
        $slide = Slide::select('title', 'file_path', 'button_title')->get()->toArray();
        $deliveryFee = DeliveryFee::select('name', 'fee')->get()->toArray();
        $pages = pages::select('name', 'slug')->get()->toArray();
        return response()->json(['status' => 200, 'data' => ['category' => $category, 'website' => $website, 'slide' => $slide, 'deliveryFee' => $deliveryFee, 'pages' => $pages]]);
    }
}
