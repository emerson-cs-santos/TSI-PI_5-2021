<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especialidade;

class EspecialidadesUnitTestSeeder extends Seeder
{
    public function run()
    {
        Especialidade::create([
            'name'  => "testeUnitInclusoSeeder"
        ]);
    }
}
