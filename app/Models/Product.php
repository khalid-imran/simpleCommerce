<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $appends = [
        'video_path',
    ];
    public function getVideoPathAttribute()
    {
        if ($this->video != null) {
            return asset('storage/uploads/'.$this->video);
        }
    }
    public function images(){
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariants::class, 'product_id', 'id');
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
