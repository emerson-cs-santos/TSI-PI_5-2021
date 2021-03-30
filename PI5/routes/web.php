<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsersController;

// teste
//Route::get('/teste', [MainController::class, 'teste']) ->name('teste');

// Não precisa de login

    // Index
    Route::get('/', [MainController::class, 'index']) ->name('index');
    Route::get('/dashboard', [MainController::class, 'index']) ->name('dashboard');


// Precisa de login
    Route::middleware(['auth:sanctum', 'verified'])->group(function()
    {
        // Perfil
        Route::get('/perfil', [PerfilController::class, 'perfil'])                              ->name('perfil');
        Route::put('perfil-atualizar', [PerfilController::class, 'updatePerfil'])               ->name('perfil-atualizar');
        Route::put('perfil-atualizar-senha', [PerfilController::class, 'updatePerfilSenha'])    ->name('perfil-atualizar-senha');
        Route::delete('perfil-apagar', [PerfilController::class, 'apagarPerfil'])               ->name('perfil-apagar');

    });


// Precisa de login e ser ADMIN
    Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
    {
        // Usuarios
        Route::resource('Users',                UsersController::class);
        Route::get('trashed-Users',             [UsersController::class, 'trashed' ] )  ->name('trashed-Users.index');
        Route::put('restore-Users/{category}',  [UsersController::class, 'restore' ] )  ->name('restore-Users.update');
        Route::any('buscar-Users',              [UsersController::class, 'buscar' ] )   ->name('buscar-Users');
    });
