<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserUnitTestSeeder extends Seeder
{
 function run()
    {
        DB::table('users')->insert([
            'name'          =>  'TesteUnit',
            'email'         =>  'testeunit@ibest.com',
            'type'          =>  'admin',
            'password'      =>  Hash::make('12345678'),
            'created_at'    =>  date("Y-m-d H:i:s"),
            'updated_at'    =>  date("Y-m-d H:i:s"),
        ]);
    }
}
