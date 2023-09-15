<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $fillable = ['status'];
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function guest(){
        return $this->hasOne(Guest::class, 'uid', 'user_id');
    }
    public function order_item(){
        return $this->hasMany(OrderItem::class, 'order_id', 'id')->with('product')->with('product_variants');
    }
    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
    public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
