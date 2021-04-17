<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name'          =>  'Admin',
            'email'         =>  'admin@ibest.com',
            'type'          =>  'admin',
            'password'      =>  Hash::make('12345678'),
            'created_at'    =>  date("Y-m-d H:i:s"),
            'updated_at'    =>  date("Y-m-d H:i:s"),
        ]);
    }
}
