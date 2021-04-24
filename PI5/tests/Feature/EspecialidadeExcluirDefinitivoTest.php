<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Especialidade;
use App\Http\Controllers\EspecialidadesController;

class EspecialidadeExcluirDefinitivoTest extends TestCase
{
    public function test()
    {
        // Gerar registro
        $this->seed('EspecialidadesUnitTestSeeder');

        $especialidade = Especialidade::where("name", "=", 'testeUnitInclusoSeeder')->first();

        if ( empty($especialidade) )
        {
            dd('Especialidade de Teste não encontrada!');
        }

        // Excluir
        $Controller = new EspecialidadesController();
        $Controller->destroy( $especialidade->id );

        // Excluir definitivamente
        $Controller->destroy( $especialidade->id );

        // Verificar se excluiu
        $especialidade = Especialidade::withTrashed()
        ->where('name', 'testeUnitInclusoSeeder')
        ->first();

        $result = false;

        if ( empty( $especialidade ) )
        {
            $result = true;
        }

        $this->assertTrue( $result );

    }
}
