<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\CasosController;
use App\Http\Requests\EditCasosRequest;
use App\Models\Caso;

class CasosAlterarTest extends TestCase
{
    public function test()
    {
        // Gerar registro
        $this->seed('CasosIsoladoUnitTestSeeder');

        $registro = Caso::where("nome", "=", 'TestUnitIsolado')->first();

        if ( empty($registro) )
        {
            dd('Caso de Teste não encontrado!');
        }

        // Alterar registro
        $request = new EditCasosRequest();
        $request->setMethod('PUT');
        $request->request->add( ['nome' => 'testeUnitAlterado'], ['status' => 'testeUnitAlterado'] );

        $controller = new CasosController();
        $controller->update( $request, $registro->id );

        // Verificar se registro foi alterado
        $result = false;

        $registro = Caso::where("nome", "=", 'testeUnitAlterado')->where("status", "=", 'testeUnitAlterado')->first();

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
