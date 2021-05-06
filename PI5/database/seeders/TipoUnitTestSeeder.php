<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoUnitTestSeeder extends Seeder
{
    public function run()
    {
        Tipo::create([
            'name'      => "testeUnitInclusoSeeder"
            ,'color'    => "#000000"
        ]);
    }
}
