<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function save(Request $request)
    {
        $requestData = $request->all();
        $image_path = null;
        if ($request->file('logo')) {
            $image = $request->file('logo');
            $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $image->getClientOriginalName());
            $image->move(storage_path('/app/public/uploads'), $name);
            $image_path = $name;
        }
        $website = new Website();
        $website->name = $requestData['name'] ?? null;
        $website->logo = $image_path;
        $website->about = $requestData['about'] ?? null;
        $website->address = $requestData['address'] ?? null;
        $website->phone = $requestData['phone'] ?? null;
        $website->email = $requestData['email'] ?? null;
        $website->social_facebook = $requestData['social_facebook'] ?? null;
        $website->social_linkedIn = $requestData['social_linkedIn'] ?? null;
        $website->social_youtube = $requestData['social_youtube'] ?? null;
        $website->social_instagram = $requestData['social_instagram'] ?? null;
        $website->social_twitter = $requestData['social_twitter'] ?? null;
        if ($website->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully saved website.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot saved website.']);
    }

    public function single(Request $request)
    {
        $result = Website::first();
        return response()->json(['status' => 200, 'data' => $result]);
    }

    public function update(Request $request)
    {
        $requestData = $request->all();
        $website = Website::first();
        if ($website == null) {
            return response()->json(['status' => 500, 'message' => 'Cannot find website.']);
        }
        $image_path = $website->logo;
        if ($request->file('logo')) {
            $image = $request->file('logo');
            $name = md5(uniqid(rand(), true)) . str_replace(' ', '-', $image->getClientOriginalName());
            $image->move(storage_path('/app/public/uploads'), $name);
            $image_path = $name;
            if (!empty($website->logo) && file_exists(public_path('storage/uploads/' . $website->logo))) {
                unlink(public_path('storage/uploads/' . $website->logo));
            }
        }
        $website->name = $requestData['name'] ?? null;
        $website->logo = $image_path;
        $website->about = $requestData['about'] ?? null;
        $website->address = $requestData['address'] ?? null;
        $website->phone = $requestData['phone'] ?? null;
        $website->email = $requestData['email'] ?? null;
        $website->social_facebook = $requestData['social_facebook'] ?? null;
        $website->social_linkedIn = $requestData['social_linkedIn'] ?? null;
        $website->social_youtube = $requestData['social_youtube'] ?? null;
        $website->social_instagram = $requestData['social_instagram'] ?? null;
        $website->social_twitter = $requestData['social_twitter'] ?? null;
        if ($website->save()) {
            return response()->json(['status' => 200, 'message' => 'Successfully updated website.']);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot updated website.']);
    }
}
