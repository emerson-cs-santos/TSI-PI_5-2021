<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Caso;
use App\Models\Especialidade;

// Inclui 2 ocorrencias para usuário e caso de testes unitários já criados
class OcorrenciaUnitTestSeeder extends Seeder
{
    public function run()
    {
        // Id do usuário de teste unitário, o seeder UserUnitTestSeeder precisa ter sido executado antes desse, senão esse seed não vai rodar
        $user = User::withTrashed()
        ->where('name', 'TesteUnit')
        ->where('email', 'testeunit@ibest.com')
        ->first();

        if ( empty($user) )
        {
            dd('Usuário de Teste não encontrado!');
        }

        // Id do caso de teste unitário, o seeder CasoUnitTestSeeder precisa ter sido executado antes desse, senão esse seed não vai rodar
        $caso = Caso::withTrashed()
        ->where('user_id',      $user->id   )
        ->where('nome',         'TestUnit'  )
        ->where('desc',         'TestUnit'  )
        ->where('status',       'Curado'    )
        ->where('medicamentos', 'TestUnit'  )
        ->first();

        if ( empty($caso) )
        {
            dd('Caso de Teste não encontrado!');
        }

       // Colocando uma especilidade qualquer
       $especialidade = Especialidade::withTrashed()
       ->orderBy('id')
       ->take(1)
       ->first();

       if ( empty($caso) )
       {
           dd('Não tem Especialidade nenhuma cadastrada!');
       }

        $this->incluirOcorrencia($user->id, $caso->id, $especialidade->id);
        $this->incluirOcorrencia($user->id, $caso->id, $especialidade->id);
    }

    function incluirOcorrencia(int $userID , int $casoID, int $especialidadeID )
    {
        DB::table('ocorrencias')->insert([
            'user_id'           =>  $userID,
            'caso_id'           =>  $casoID,
            'especialidade_id'  =>  $especialidadeID,
            'tipo'              =>  'Consulta',
            'importancia'       =>  'Rotina',
            'data'              =>  date("Y-m-d H:i:s"),
            'medico'            =>  'TestUnit',
            'crm'               =>  'TestUnit',
            'receitas'          =>  'TestUnit',
            'local'             =>  'TestUnit',
            'desc'              =>  'TestUnit',
            'resumo'            =>  'TestUnit',
            'created_at'        =>  date("Y-m-d H:i:s"),
            'updated_at'        =>  date("Y-m-d H:i:s"),
        ]);
    }
}
