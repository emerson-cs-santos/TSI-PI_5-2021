<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\CasosController;
use App\Models\Caso;

class CasosExcluirTest extends TestCase
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

        // Verificar se registro foi alterado
        $result = false;

        // Excluir
        $Controller = new CasosController();
        $Controller->destroy( $registro->id );

        // Verificar se foi excluido
        $registro = Caso::withTrashed("nome", "=", 'TestUnitIsolado')->where("status", "=", 'TestUnitIsolado')->first();

        if ( $registro->trashed() )
        {
            // Reativar
            $Controller->restore( $registro->id );

            // Verificar se reativou
            $registro = Caso::withTrashed("nome", "=", 'TestUnitIsolado')->where("status", "=", 'TestUnitIsolado')->first();

            if ( !$registro->trashed() )
            {
                // Excluir
                $Controller->destroy( $registro->id );

                // Excluir definitivamente
                $Controller->destroy( $registro->id );

                // Verificar se excluiu definitivamente
                $registro = Caso::withTrashed("nome", "=", 'TestUnitIsolado')->where("status", "=", 'TestUnitIsolado')->first();

                if ( !empty( $registro ) )
                {
                    $result = true;
                }
            }
        }

        $this->assertTrue( $result );
    }
}
