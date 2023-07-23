<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function backend()
    {
        return view('backend');
    }
    public function frontend()
    {
        return view('frontend');
    }
}
