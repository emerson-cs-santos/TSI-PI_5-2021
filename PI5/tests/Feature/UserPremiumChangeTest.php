<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\UsersController;
use App\Models\User;
use App\Http\Controllers\PerfilController;

class UserPremiumChangeTest extends TestCase
{
    // Será criado um usuário como adm, e depois a rotina vai mudar para default. Então será verificado se a mudança ocorreu.

    public function test()
    {
    // Setup Test
        // Criar usuário - usuário criado como adm
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

    // Execute Test - Vai mudar de adm para default
        $userController = new UsersController();
        $users = $userController->typeUpdate($user->id);

    // Validate Test - Verificar se mudou para default
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

        if ( $user->type == 'default' )
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
