<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\CasosController;
use App\Http\Controllers\OcorrenciasController;
use App\Http\Controllers\RelatorioController;

// Não precisa de login
    // Index
    Route::get('/',             [MainController::class, 'index']) ->name('index');
    Route::get('/dashboard',    [MainController::class, 'index']) ->name('dashboard');

    // Sobre
    Route::get('/sobre',             [MainController::class, 'sobre']) ->name('sobre');

    // Termos de uso e Politica de privacidade
    Route::get('/termos',             [MainController::class, 'termos']) ->name('termos');

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
        Route::get('ocorrencias-index/{caso}',                                  [OcorrenciasController::class, 'index' ] )          ->name('Ocorrencias.index');
        Route::get('Ocorrencias-create/{caso}',                                 [OcorrenciasController::class, 'create' ] )         ->name('Ocorrencias.create');
        Route::post('Ocorrencias-store/{caso}',                                 [OcorrenciasController::class, 'store' ] )          ->name('Ocorrencias.store');
        Route::get('ocorrencias-show/{caso}/{ocorrencia}',                      [OcorrenciasController::class, 'show' ] )           ->name('Ocorrencias.show');
        Route::get('ocorrencias-edit/{caso}/{ocorrencia}',                      [OcorrenciasController::class, 'edit' ] )           ->name('Ocorrencias.edit');
        Route::put('ocorrencias-update/{caso}/{ocorrencia}',                    [OcorrenciasController::class, 'update' ] )         ->name('Ocorrencias.update');
        Route::delete('ocorrencias-destroy/{caso}/{ocorrencia}',                [OcorrenciasController::class, 'destroy' ] )        ->name('Ocorrencias.destroy');

        Route::get('trashed-Ocorrencias/{caso}',                                [OcorrenciasController::class, 'trashed' ] )        ->name('trashed-Ocorrencias.index');
        Route::put('restore-Ocorrencias/{caso}/{ocorrencia}',                   [OcorrenciasController::class, 'restore' ] )        ->name('restore-Ocorrencias.update');
        Route::any('buscar-Ocorrencias/{caso}',                                 [OcorrenciasController::class, 'buscar' ] )         ->name('buscar-Ocorrencias');
        Route::any('buscar-Ocorrencias-data/{caso}',                            [OcorrenciasController::class, 'buscarData' ] )     ->name('buscar-Ocorrencias.data');

        Route::get('ocorrencias-file/{caso}/{ocorrencia}/{nomearquivo}',        [OcorrenciasController::class, 'getfile' ] )        ->name('Ocorrencias.getfile');
        Route::get('ocorrencias-file-todos/{caso}/{ocorrencia}',                [OcorrenciasController::class, 'getfileTodos' ] )   ->name('Ocorrencias.getfileTodos');
        Route::get('ocorrencias-delete-file/{caso}/{ocorrencia}/{nomearquivo}', [OcorrenciasController::class, 'deletefile' ] )     ->name('Ocorrencias.deletefile');

        // Relatório
        Route::get('relatorio',             [RelatorioController::class, 'relatorio'])          ->name('relatorio');
        Route::any('relatorio-impressao',   [RelatorioController::class, 'relatorioImpressao']) ->name('relatorio.impressao');
        Route::any('buscar-relatorio',      [RelatorioController::class, 'relatorioBuscar' ] )  ->name('buscar-relatorio');
        Route::any('relatorio-file-todos',  [RelatorioController::class, 'getfileTodos' ] )     ->name('relatorio.getfileTodos');

        // Premium
        Route::get('premium',       [MainController::class, 'premium'])         ->name('premium');
        Route::put('premium-mudar', [MainController::class, 'premiumMudar'])    ->name('premium.mudar');
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
