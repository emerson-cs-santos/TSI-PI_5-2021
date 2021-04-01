<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Http\Requests\CreateOcorrenciasRequest;
use App\Http\Requests\EditOcorrenciasRequest;
use Illuminate\Support\Facades\Auth;

class OcorrenciasController extends Controller
{
    public function index( $casoId )
    {
        $ocorrencias = Ocorrencia::selectRaw('casos.*')->where('caso_id', '=', $casoId )->where('user_id', '=', Auth::user()->id )->orderByDesc('id')->paginate(5);

        return view('ocorrencias.index', ['ocorrencias' => $ocorrencias]);
    }
}
