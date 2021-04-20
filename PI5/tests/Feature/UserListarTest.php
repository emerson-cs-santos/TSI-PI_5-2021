<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\UsersController;

class UserListarTest extends TestCase
{
    public function test()
    {
        $userController = new UsersController();
        $users = $userController->indexBanco();

        $result = false;

        if ( !empty($users) )
        {
            $result = true;
        }

        $this->assertTrue( $result );
    }
}
