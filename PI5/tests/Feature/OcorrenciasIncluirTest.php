<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\OcorrenciasController;
use App\Http\Requests\CreateOcorrenciasRequest;
use App\Models\Ocorrencia;
use Illuminate\Support\Facades\Auth;

class OcorrenciasIncluirTest extends TestCase
{
    public function test()
    {
        // Incluir registro
        $request = new CreateOcorrenciasRequest();
        $request->setMethod('POST');
        $request->request->add( ['especialidade_id' => 0], ['tipo' => 'testeUnit'], ['data' => date("Y-m-d H:i:s") ], ['importancia' => 'testeUnit'], ['resumo' => 'testeUnit'] );

        $controller = new OcorrenciasController();
        $controller->store($request, 0);

        // Verificar se registro foi incluso
        $result = false;

        $registro = Ocorrencia::where("tipo", "=", 'testeUnit')->where("importancia", "=", 'testeUnit')->first();

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
