<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Caso;

class CasosIsoladoUnitTestSeeder extends Seeder
{
    public function run()
    {
        Caso::create([
            'user_id'       => 0
            ,'nome'         => 'TestUnitIsolado'
            ,'desc'         => 'TestUnitIsolado'
            ,'status'       => 'TestUnitIsolado'
            ,'medicamentos' => 'TestUnitIsolado'
        ]);
    }
}
