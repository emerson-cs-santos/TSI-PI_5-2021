<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PerfilController;

class UserDeleteTest extends TestCase
{
    public function test()
    {
    // Setup Test
        // Criar usuário
        $this->seed('UserUnitTestSeeder');

        // Id do usuário de teste unitário, o seeder UserUnitTestSeeder precisa ter sido executado antes desse, senão esse seed não vai rodar
        $user = User::withTrashed()
        ->where('name', 'TesteUnit')
        ->where('email', 'testeunit@ibest.com')
        ->first();

        if ( empty($user) )
        {
            dd('Usuário de Teste não encontrado!');
        }

    // Execute Test
        $userController = new UsersController();
        $userController->destroyBanco($user->id);

    // Validate Test
        // Id do usuário de teste unitário, o seeder UserUnitTestSeeder precisa ter sido executado antes desse, senão esse seed não vai rodar
        $user = User::withTrashed()
        ->where('name', 'TesteUnit')
        ->where('email', 'testeunit@ibest.com')
        ->first();

        if ( empty($user) )
        {
            dd('Usuário de Teste não encontrado!');
        }

        $result = false;

        if ( $user->trashed() )
        {
            $result = true;
        }

    // After Test
        $perfilController = new PerfilController();
        $perfilController->apagarPerfilBanco( $user->id  );

    // Test Result
    $this->assertTrue( $result );

    }
}
