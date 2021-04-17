<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Http\Controllers\PerfilController;
use App\Models\User;
use App\Models\Caso;
use App\Models\Ocorrencia;

class UserDeleteProfileTest extends TestCase
{
    public function main()
    {
        $this->test();
    }

    function test()
    {

    // Setup Test
        // Criar usuário
       $this->seed('UserUnitTestSeeder');

        // Criar caso
       $this->seed('CasoUnitTestSeeder');

       // Criar Ocorrencias 2 pelo menos para o caso criado
       $this->seed('OcorrenciaUnitTestSeeder');

    // Execute Test
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

        // Chamar rotina de apagar usuário
       //PerfilController::apagarPerfilBanco($user->id); Laravel não permite mais usar chamda estática
       $perfilController = new PerfilController();
       $perfilController->apagarPerfilBanco( $user->id  );

    // Verify:
        // Se ocorrencias foram excluidas
        $ocorrencias = Ocorrencia::withTrashed()
        ->where('user_id',      $user->id   )
        ->where('caso_id',      $caso->id   )
        ->where('tipo',         'Consulta'  )
        ->where('importancia',  'Rotina'    )
        ->where('medico',       'TestUnit'  )
        ->where('crm',          'TestUnit'  )
        ->where('receitas',     'TestUnit'  )
        ->where('local',        'TestUnit'  )
        ->where('desc',         'TestUnit'  )
        ->where('resumo',       'TestUnit'  )
        ->first();

        // Se caso foi excluido
        $caso = Caso::withTrashed()
        ->where('user_id',      $user->id   )
        ->where('nome',         'TestUnit'  )
        ->where('desc',         'TestUnit'  )
        ->where('status',       'Curado'    )
        ->where('medicamentos', 'TestUnit'  )
        ->first();

        // Se usuário foi excluido
        $user = User::withTrashed()
        ->where('name', 'TesteUnit')
        ->where('email', 'testeunit@ibest.com')
        ->first();

        $resultadoTeste = false;
        if ( empty($ocorrencias) and empty($caso) and empty($caso) )
        {
            $resultadoTeste = true;
        }

    // Resultado do teste
        $this->assertTrue( $resultadoTeste );
    }
}
