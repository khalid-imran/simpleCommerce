<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $appends = [
        'full_path',
    ];
    public function getFullPathAttribute()
    {
        if ($this->file_path != null) {
            return asset('storage/uploads/'.$this->file_path);
        }
    }
}
