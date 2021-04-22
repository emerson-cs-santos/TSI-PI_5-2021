<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\EspecialidadesController;

class EspecialidadeListarTest extends TestCase
{
    public function test()
    {
        $especialidadesController = new EspecialidadesController();
        $especialidades = $especialidadesController->indexBanco();

        $result = false;

        if ( !empty($especialidades) )
        {
            $result = true;
        }

        $this->assertTrue( $result );
    }
}
