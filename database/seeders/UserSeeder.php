<?php

namespace Database\Seeders;

use App\Console\Common\SchoolRole;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'diivaa-admin', 'phone' => 'admin', 'password' => bcrypt('12345678!@'), 'is_admin' => 1]
        ];
        User::insert($data);
    }
}
