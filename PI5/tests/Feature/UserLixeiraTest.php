<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\UsersController;

class UserLixeiraTest extends TestCase
{
    public function test()
    {
        $userController = new UsersController();
        $users = $userController->trashedBanco();

        $result = true;

        // Verifica se todos os itens da lixeira estão de fato deletados
        foreach ($users as $item)
        {
            if ( !$item->trashed() )
            {
                $result = false;
            }
        }

        $this->assertTrue( $result );
    }
}
