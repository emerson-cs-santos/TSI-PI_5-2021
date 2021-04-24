<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ocorrencia;

class OcorrenciasIsoladoUnitTestSeeder extends Seeder
{
    public function run()
    {
        $ocorrencia = Ocorrencia::create([
            'user_id'           => 0
            ,'caso_id'          => 0
            ,'especialidade_id' => 0
            ,'tipo'             => 'TestUnitIsolado'
            ,'data'             => date("Y-m-d H:i:s")
            ,'importancia'      => 'TestUnitAlterar'
            ,'resumo'           => 'TestUnitAlterar'
            ,'local'            => 'TestUnitAlterar'
            ,'medico'           => 'TestUnitAlterar'
            ,'crm'              => 'TestUnitAlterar'
            ,'receitas'         => 'TestUnitAlterar'
            ,'desc'             => 'TestUnitAlterar'
        ]);
    }
}
