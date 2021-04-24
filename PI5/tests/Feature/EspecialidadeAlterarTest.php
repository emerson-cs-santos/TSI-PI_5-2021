<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Requests\EditEspecialidadesRequest;
use App\Models\Especialidade;

class EspecialidadeAlterarTest extends TestCase
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

        // Alterar registro
        $request = new EditEspecialidadesRequest();
        $request->setMethod('PUT');
        $request->request->add(['name' => 'testeUnitAlterado']);

        $especialidadesController = new EspecialidadesController();
        $especialidadesController->update( $request, $especialidade->id );

        // Verificar se registro foi alterado
        $result = false;

        $especialidade = Especialidade::where("name", "=", 'testeUnitAlterado')->first();

        if ( !empty( $especialidade ) )
        {
            $result = true;

            // Move para lixeira se ainda não foi excluido
            $especialidadesController->destroy( $especialidade->id );

            // Se já estiver na lixeira, ao tentar excluir novamente, excluir permanentemente
            $especialidadesController->destroy( $especialidade->id );
        }

        $this->assertTrue( $result );
    }
}
