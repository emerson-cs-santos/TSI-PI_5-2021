<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TiposController;

class TipoListarTest extends TestCase
{
    public function test()
    {
        $tiposController = new TiposController();
        $tipos = $tiposController->indexBanco();

        $result = false;

        if ( !empty($tipos) )
        {
            $result = true;
        }

        $this->assertTrue( $result );
    }
}
