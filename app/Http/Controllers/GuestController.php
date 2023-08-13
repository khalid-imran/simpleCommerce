<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    public function createGuest(Request $request)
    {
        $guest = new Guest();
        $guest->uid = 'g'.time();
        $guest->save();
        return response()->json(['status' => 200, 'msg' => 'Guest Account created successfully', 'guest' => Guest::parseData($guest)]);
    }
    public function getGuest(Request $request)
    {
        $inputData = $request->all();
        $guest = Guest::find($inputData['id']);
        if ($guest != null) {
            return response()->json(['status' => 200, 'guest' => Guest::parseData($guest)]);
        }
        return response()->json(['status' => 500, 'message' => 'Cannot find guest'], 200);
    }
}
