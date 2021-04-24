<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Requests\CreateEspecialidadesRequest;
use App\Models\Especialidade;

class EspecialidadeIncluirTest extends TestCase
{
    public function test()
    {
        // Incluir registro
        $request = new CreateEspecialidadesRequest();
        $request->setMethod('POST');
        $request->request->add(['name' => 'testeUnit']);

        $especialidadesController = new EspecialidadesController();
        $especialidadesController->store($request);

        // Verificar se registro foi incluso
        $result = false;

        $especialidade = Especialidade::where("name", "=", 'testeUnit')->first();

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
