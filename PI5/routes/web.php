<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\CasosController;
use App\Http\Controllers\OcorrenciasController;


// teste
//Route::get('/teste', [MainController::class, 'teste']) ->name('teste');

// Não precisa de login

    // Index
    Route::get('/', [MainController::class, 'index']) ->name('index');
    Route::get('/dashboard', [MainController::class, 'index']) ->name('dashboard');

    // Sobre
    // usar MainController

// Precisa de login
    Route::middleware(['auth:sanctum', 'verified'])->group(function()
    {
        // Perfil
        Route::get('/perfil',                   [PerfilController::class, 'perfil'])            ->name('perfil');
        Route::put('perfil-atualizar',          [PerfilController::class, 'updatePerfil'])      ->name('perfil-atualizar');
        Route::put('perfil-atualizar-senha',    [PerfilController::class, 'updatePerfilSenha']) ->name('perfil-atualizar-senha');
        Route::delete('perfil-apagar',          [PerfilController::class, 'apagarPerfil'])      ->name('perfil-apagar');

        // Casos
        Route::resource('Casos',                CasosController::class);
        Route::get('trashed-Casos',             [CasosController::class, 'trashed' ] )          ->name('trashed-Casos.index');
        Route::put('restore-Casos/{caso}',      [CasosController::class, 'restore' ] )          ->name('restore-Casos.update');
        Route::any('buscar-Casos',              [CasosController::class, 'buscar' ] )           ->name('buscar-Casos');

        // Ocorrencias
        Route::get('ocorrencias-index/{caso}',         [OcorrenciasController::class, 'index' ] ) ->name('casos-index');

        // Relatório

        // Premium
        // usar MainController
    });


// Precisa de login e ser ADMIN
    Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
    {
        // Usuarios
        Route::resource('Users',                UsersController::class);
        Route::get('trashed-Users',             [UsersController::class, 'trashed' ] )      ->name('trashed-Users.index');
        Route::put('restore-Users/{user}',      [UsersController::class, 'restore' ] )      ->name('restore-Users.update');
        Route::any('buscar-Users',              [UsersController::class, 'buscar' ] )       ->name('buscar-Users');
        Route::put('perfil-type/{user}',        [UsersController::class, 'typeUpdate' ] )   ->name('perfil-type');

        // Especialidades
        Route::resource('Especialidades',                       EspecialidadesController::class);
        Route::get('trashed-Especialidades',                    [EspecialidadesController::class, 'trashed' ] )     ->name('trashed-Especialidades.index');
        Route::put('restore-Especialidades/{especialidade}',   [EspecialidadesController::class, 'restore' ] )      ->name('restore-Especialidades.update');
        Route::any('buscar-Especialidades',                     [EspecialidadesController::class, 'buscar' ] )      ->name('buscar-Especialidades');
    });
