<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TiposController;
use App\Http\Requests\EditTiposRequest;
use App\Models\Tipo;

class TipoAlterarTest extends TestCase
{
    public function test()
    {
        // Gerar registro
        $this->seed('TipoUnitTestSeeder');

        $tipo = Tipo::where("name", "=", 'testeUnitInclusoSeeder')->first();

        if ( empty($tipo) )
        {
            dd('Tipo de Teste não encontrado!');
        }

        // Alterar registro
        $request = new EditTiposRequest();
        $request->setMethod('PUT');
        $request->request->add(['name' => 'testeUnitAlterado']);
        $request->request->add(['color' => '#000000']);

        $tiposController = new TiposController();
        $tiposController->update( $request, $tipo->id );

        // Verificar se registro foi alterado
        $result = false;

        $tipo = Tipo::where("name", "=", 'testeUnitAlterado')->first();

        if ( !empty( $tipo ) )
        {
            $result = true;

            // Move para lixeira se ainda não foi excluido
            $tiposController->destroy( $tipo->id );

            // Se já estiver na lixeira, ao tentar excluir novamente, excluir permanentemente
            $tiposController->destroy( $tipo->id );
        }

        $this->assertTrue( $result );
    }
}
