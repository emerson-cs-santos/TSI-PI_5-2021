<?php

namespace App\Http\Controllers;
use App\Models\Ocorrencia;
use App\Models\Caso;
use App\Models\Especialidade;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function relatorio()
    {
        $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso')
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->join('casos', 'casos.id', 'ocorrencias.caso_id')
        ->where('ocorrencias.user_id', '=', Auth::user()->id )
        ->orderByDesc('id')
        ->paginate(5);

        return view('relatorio.index', ['registros' => $registros]);
    }

    public function relatorioBuscar()
    {
        return view('relatorio.index');
    }

    public function relatorioImpressao()
    {


        return view('relatorio.impressao');
    }
}
