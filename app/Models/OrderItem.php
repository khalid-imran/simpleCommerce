<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function product()
    {
        return $this->hasOne(Product::Class, 'id', 'product_id')->with('images');
    }
    public function product_variants()
    {
        return $this->hasMany(ProductVariants::class, 'id', 'product_variant_id');
    }

}
