<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\OcorrenciasController;
use App\Http\Requests\EditOcorrenciasRequest;
use App\Models\Ocorrencia;

class OcorrenciasAlterarTest extends TestCase
{
    public function test()
    {
        // Gerar registro
        $this->seed('OcorrenciasIsoladoUnitTestSeeder');

        $registro = Ocorrencia::where("tipo", "=", 'TestUnitIsolado')->first();

        if ( empty($registro) )
        {
            dd('Ocorrência de Teste não encontrada!');
        }

        // Alterar registro
        $request = new EditOcorrenciasRequest();
        $request->setMethod('PUT');
        $request->request->add( ['especialidade_id' => 0], ['tipo' => 'testeUnitAlterado'], ['data' => date("Y-m-d H:i:s") ], ['importancia' => 'testeUnitAlterado'], ['resumo' => 'testeUnitAlterado'] );

        $controller = new OcorrenciasController();
        $controller->update( $request, $registro->caso_id, $registro->id );

        // Verificar se registro foi alterado
        $result = false;

        $registro = Ocorrencia::where("tipo", "=", 'testeUnitAlterado')->where("importancia", "=", 'testeUnitAlterado')->first();

        if ( !empty( $registro ) )
        {
            $result = true;

            // Move para lixeira se ainda não foi excluido
            $controller->destroy( $registro->caso_id, $registro->id );

            // Se já estiver na lixeira, ao tentar excluir novamente, excluir permanentemente
            $controller->destroy( $registro->caso_id, $registro->id );
        }

        $this->assertTrue( $result );
    }
}
