<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\CasosController;
use App\Http\Requests\CreateCasosRequest;
use App\Models\Caso;
use Illuminate\Support\Facades\Auth;

class CasosIncluirTest extends TestCase
{
    public function test()
    {
        // Incluir registro
        $request = new CreateCasosRequest();
        $request->setMethod('POST');
        $request->request->add( ['nome' => 'testeUnit'], ['status' => 'testeUnit'] );

        $controller = new CasosController();
        $controller->store($request);

        // Verificar se registro foi incluso
        $result = false;

        $registro = Caso::where("nome", "=", 'testeUnit')->where("status", "=", 'testeUnit')->first();

        if ( !empty( $registro ) )
        {
            $result = true;

            // Move para lixeira se ainda não foi excluido
            $controller->destroy( $registro->id );

            // Se já estiver na lixeira, ao tentar excluir novamente, excluir permanentemente
            $controller->destroy( $registro->id );
        }

        $this->assertTrue( $result );
    }
}
