<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Caso;
use App\Models\Especialidade;
use App\Http\Requests\CreateOcorrenciasRequest;
use App\Http\Requests\EditOcorrenciasRequest;
use Illuminate\Support\Facades\Auth;

class OcorrenciasController extends Controller
{
    public function index( $casoId )
    {
        $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->where('caso_id', '=', $casoId )
        ->where('user_id', '=', Auth::user()->id )
        ->orderByDesc('id')
        ->paginate(5);

        $caso = Caso::withTrashed()->where('id', $casoId)->firstOrFail();

        return view('ocorrencias.index', ['ocorrencias' => $ocorrencias])->with( ['casoId' => $casoId] )->with( ['caso' => $caso->nome] );
    }

    public function create( $casoId )
    {
        return view('ocorrencias.create')->with( ['casoId' => $casoId] )->with('especialidades', Especialidade::orderBy('name')->get() );
    }


    public function trashed( $casoId )
    {
        $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')->onlyTrashed()
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->where('caso_id', '=', $casoId )
        ->where('user_id', '=', Auth::user()->id )
        ->orderByDesc('id')
        ->paginate(5);

        $caso = Caso::withTrashed()->where('id', $casoId)->firstOrFail();

        return view('ocorrencias.index', ['ocorrencias' => $ocorrencias])->with( ['casoId' => $casoId] )->with( ['caso' => $caso->nome] );
    }
}
