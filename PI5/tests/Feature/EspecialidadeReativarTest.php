<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Especialidade;
use App\Http\Controllers\EspecialidadesController;

class EspecialidadeReativarTest extends TestCase
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

        // Reativar
        $Controller->restore( $especialidade->id );

        // Verificar se reativou
        $especialidade = Especialidade::withTrashed()
        ->where('name', 'testeUnitInclusoSeeder')
        ->first();

        $result = false;

        if ( !$especialidade->trashed() )
        {
            $result = true;

            // Apagar registro novamente
            $Controller->destroy( $especialidade->id );

            // Apagar registro definitivamente
            $Controller->destroy( $especialidade->id );
        }

        $this->assertTrue( $result );

    }
}
