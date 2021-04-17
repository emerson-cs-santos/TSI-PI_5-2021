<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class CasoUnitTestSeeder extends Seeder
{
    public function run()
    {
        // Id do usuário de teste unitário, precisa ter sido executado antes desse, senão esse seed não vai rodar
        $user = User::withTrashed()
        ->where('name', 'TesteUnit')
        ->where('email', 'testeunit@ibest.com')
        ->first();

        if ( empty($user) )
        {
            dd('Usuário de Teste não encontrado!');
        }
        else
        {
            DB::table('casos')->insert([
                'user_id'       =>  $user->id,
                'nome'          =>  'TestUnit',
                'desc'          =>  'TestUnit',
                'status'        =>  'Curado',
                'medicamentos'  =>  'TestUnit',
                'created_at'    =>  date("Y-m-d H:i:s"),
                'updated_at'    =>  date("Y-m-d H:i:s"),
            ]);
        }
    }
}
