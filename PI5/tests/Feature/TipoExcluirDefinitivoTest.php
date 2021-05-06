<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tipo;
use App\Http\Controllers\TiposController;

class TipoExcluirDefinitivoTest extends TestCase
{
    public function test()
    {
        // Gerar registro
        $this->seed('TipoUnitTestSeeder');

        $tipo = Tipo::where("name", "=", 'testeUnitInclusoSeeder')->first();

        if ( empty($tipo) )
        {
            dd('Tipo de Teste não encontrada!');
        }

        // Excluir
        $Controller = new TiposController();
        $Controller->destroy( $tipo->id );

        // Excluir definitivamente
        $Controller->destroy( $tipo->id );

        // Verificar se excluiu
        $tipo = Tipo::withTrashed()
        ->where('name', 'testeUnitInclusoSeeder')
        ->first();

        $result = false;

        if ( empty( $tipo ) )
        {
            $result = true;
        }

        $this->assertTrue( $result );
    }
}
