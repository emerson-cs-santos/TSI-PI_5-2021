<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TiposController;
use App\Http\Requests\CreateTiposRequest;
use App\Models\Tipo;

class TipoIncluirTest extends TestCase
{
    public function test()
    {
        // Incluir registro
        $request = new CreateTiposRequest();
        $request->setMethod('POST');
        $request->request->add(['name' => 'testeUnit']);
        $request->request->add(['color' => '#000000']);

        $tiposController = new TiposController();
        $tiposController->store($request);

        // Verificar se registro foi incluso
        $result = false;

        $tipo = Tipo::where("name", "=", 'testeUnit')->first();

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
