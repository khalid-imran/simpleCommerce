<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Guest extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public static function parseData($userInfo)
    {
        return [
            'id' => $userInfo['id'],
            'uid' => $userInfo['uid'],
            'name' => $userInfo['name'],
            'phone' => $userInfo['phone'],
            'address' => $userInfo['phone'],
        ];
    }
}
