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
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function guest(){
        return $this->hasOne(Guest::class, 'uid', 'user_id');
    }
}
