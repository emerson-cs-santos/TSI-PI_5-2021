<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MainController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\CasosController;
use App\Http\Controllers\OcorrenciasController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\RedeSocialLoginController;
use App\Http\Controllers\TiposController;

// Login com redes sociais
Route::get('login/{provider}',          [RedeSocialLoginController::class, 'redirectToProvider'])->name('login.rede.social');
Route::get('login/{provider}/callback', [RedeSocialLoginController::class, 'handleProviderCallback'])->name('rede.social.callback');

// Não precisa de login
    // Index
    Route::get('/',             [MainController::class, 'index']) ->name('index');
    Route::get('/dashboard',    [MainController::class, 'index']) ->name('dashboard');

    // Sobre
    Route::get('/sobre',             [MainController::class, 'sobre']) ->name('sobre');

    // Ajuda
    Route::get('/ajuda',             [MainController::class, 'ajuda']) ->name('ajuda');

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
        Route::any('buscar-Casos-trashed',      [CasosController::class, 'buscarTrashed' ] )    ->name('buscar-Casos-trashed');

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
        Route::any('buscar-Ocorrencias-Trashed/{caso}',                         [OcorrenciasController::class, 'buscarTrashed' ] )  ->name('buscar-Ocorrencias-Trashed');

        Route::get('ocorrencias-file/{caso}/{ocorrencia}/{nomearquivo}',        [OcorrenciasController::class, 'getfile' ] )        ->name('Ocorrencias.getfile');
        Route::get('ocorrencias-file-todos/{caso}/{ocorrencia}',                [OcorrenciasController::class, 'getfileTodos' ] )   ->name('Ocorrencias.getfileTodos');
        Route::get('ocorrencias-delete-file/{caso}/{ocorrencia}/{nomearquivo}', [OcorrenciasController::class, 'deletefile' ] )     ->name('Ocorrencias.deletefile');

        // Relatório
        Route::get('relatorio',             [RelatorioController::class, 'relatorio'])          ->name('relatorio');
        Route::any('relatorio-impressao',   [RelatorioController::class, 'relatorioImpressao']) ->name('relatorio.impressao');
        Route::any('buscar-relatorio',      [RelatorioController::class, 'relatorioBuscar' ] )  ->name('buscar-relatorio');
        Route::any('relatorio-file-todos',  [RelatorioController::class, 'getfileTodos' ] )     ->name('relatorio.getfileTodos');
        Route::post('relatorio-email',       [RelatorioController::class, 'impressaoEmail' ] )   ->name('relatorio.email');

        // Premium
        Route::get('premium',       [MainController::class, 'premium'])         ->name('premium');
        Route::put('premium-mudar', [MainController::class, 'premiumMudar'])    ->name('premium.mudar');
    });


// Precisa de login e ser ADMIN
    Route::middleware(['auth:sanctum', 'verified', 'is_admin'])->group(function()
    {
        // Usuarios
        Route::resource('Users',                UsersController::class);
        Route::get('trashed-Users',             [UsersController::class, 'trashed' ] )          ->name('trashed-Users.index');
        Route::put('restore-Users/{user}',      [UsersController::class, 'restore' ] )          ->name('restore-Users.update');
        Route::any('buscar-Users',              [UsersController::class, 'buscar' ] )           ->name('buscar-Users');
        Route::any('buscar-Users-trashed',      [UsersController::class, 'buscarTrashed' ] )   ->name('buscar-Users-trashed');
        Route::put('perfil-type/{user}',        [UsersController::class, 'typeUpdate' ] )       ->name('perfil-type');

        // Especialidades
        Route::resource('Especialidades',                       EspecialidadesController::class);
        Route::get('trashed-Especialidades',                    [EspecialidadesController::class, 'trashed' ] )         ->name('trashed-Especialidades.index');
        Route::put('restore-Especialidades/{especialidade}',    [EspecialidadesController::class, 'restore' ] )         ->name('restore-Especialidades.update');
        Route::any('buscar-Especialidades',                     [EspecialidadesController::class, 'buscar' ] )          ->name('buscar-Especialidades');
        Route::any('buscar-Especialidades-trashed',             [EspecialidadesController::class, 'buscarTrashed' ] )   ->name('buscar-Especialidades-trashed');

        // Tipos
        Route::resource('Tipos',                        TiposController::class);
        Route::get('trashed-Tipos',                    [TiposController::class, 'trashed' ] )       ->name('trashed-Tipos.index');
        Route::put('restore-Tipos/{especialidade}',    [TiposController::class, 'restore' ] )       ->name('restore-Tipos.update');
        Route::any('buscar-Tipos',                     [TiposController::class, 'buscar' ] )        ->name('buscar-Tipos');
        Route::any('buscar-Tipos-trashed',             [TiposController::class, 'buscarTrashed' ] ) ->name('buscar-Tipos-trashed');
    });
