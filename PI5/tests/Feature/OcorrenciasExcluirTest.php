<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\OcorrenciasController;
use App\Models\Ocorrencia;

class OcorrenciasExcluirTest extends TestCase
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

        // Verificar se registro foi alterado
        $result = false;

        // Excluir
        $Controller = new OcorrenciasController();
        $Controller->destroy( $registro->caso_id, $registro->id );

        // Verificar se foi excluido
        $registro = Ocorrencia::withTrashed("tipo", "=", 'TestUnitIsolado')->where("importancia", "=", 'TestUnitIsolado')->first();

        if ( $registro->trashed() )
        {
            // Reativar
            $Controller->restore( $registro->caso_id, $registro->id );

            // Verificar se reativou
            $registro = Ocorrencia::withTrashed("tipo", "=", 'TestUnitIsolado')->where("importancia", "=", 'TestUnitIsolado')->first();

            if ( !$registro->trashed() )
            {
                // Excluir
                $Controller->destroy( $registro->caso_id, $registro->id );

                // Excluir definitivamente
                $Controller->destroy( $registro->caso_id, $registro->id );

                // Verificar se excluiu definitivamente
                $registro = Ocorrencia::withTrashed("tipo", "=", 'TestUnitIsolado')->where("importancia", "=", 'TestUnitIsolado')->first();

                if ( !empty( $registro ) )
                {
                    $result = true;
                }
            }
        }

        $this->assertTrue( $result );
    }
}
