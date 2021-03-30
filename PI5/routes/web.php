<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;


// Não precisa de login

    // Index
    Route::get('/', [MainController::class, 'index']) ->name('index');
    Route::get('/dashboard', [MainController::class, 'index']) ->name('index');


// Precisa de login
    Route::middleware(['auth:sanctum', 'verified'])->group(function()
    {
        // Perfil
        Route::get('/perfil', [MainController::class, 'perfil']) ->name('perfil');

        // teste
        Route::get('/teste', [MainController::class, 'teste']) ->name('teste');

    });


// Precisa de login e ser ADMIN
    Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
    {

    });
