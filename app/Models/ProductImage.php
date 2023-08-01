<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
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
