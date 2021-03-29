<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;

// remover
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
// remover


// Não precisa de login

    // Index
    Route::get('/', [MainController::class, 'index']) ->name('index');


// Precisa de login
    Route::middleware(['auth:sanctum', 'verified'])->group(function()
    {
        // Perfil
        Route::get('/perfil', [MainController::class, 'perfil']) ->name('perfil');

    });

// Precisa de login e ser ADMIN
    Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
    {

    });
