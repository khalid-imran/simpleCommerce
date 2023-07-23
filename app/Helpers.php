<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class Helpers
{
    public static function uploadImage($file)
    {
        $photo = \Image::make($file);
        $photo->resize(1080, null, function ($constraint) { $constraint->aspectRatio(); } )
            ->encode('jpg',80);
        $file_path = uniqid() . time() . '.jpg';
        Storage::disk('public')->put( '/uploads/images/'.$file_path, $photo);
        return $file_path;
    }
}
