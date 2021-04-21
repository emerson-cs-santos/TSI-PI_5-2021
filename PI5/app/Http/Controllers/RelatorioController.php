<?php

namespace App\Http\Controllers;
use App\Models\Ocorrencia;
use App\Models\Caso;
use App\Models\Especialidade;
use App\Models\User;
use App\Models\Arquivo;
use ZipArchive;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function relatorio()
    {
        $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos')
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->join('casos', 'casos.id', 'ocorrencias.caso_id')
        ->where('ocorrencias.user_id', '=', Auth::user()->id )
        ->orderByDesc('id')
        ->take(5)
        ->get();

        return view('relatorio.index', ['registros' => $registros])
        ->with('buscarTipo','simples')
        ->with('busca', '')
        ->with('buscarDataInicial','')
        ->with('buscarDataFinal','');
    }

    public function relatorioBuscar( Request $request )
    {
        $buscarTipo         = $request->input('tipo');
        $buscar             = $request->input('busca');
        $buscarDataInicial  = $request->input('dataInicial');
        $buscarDataFinal    = $request->input('dataFinal');

        $buscaTotal = $buscar .  $buscarDataInicial . $buscarDataFinal;

        $buscaPorData = $buscarDataInicial . $buscarDataFinal;

        if( empty($buscarDataInicial) )
        {
            $buscarDataInicial = "1";
        }

        if( empty($buscarDataFinal) )
        {
            $buscarDataFinal = '3000-01-01 00:00:00';
        }

        if($buscaTotal != "")
        {
            if ( empty($buscaPorData) )
            {
                $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->join('casos', 'casos.id', 'ocorrencias.caso_id')
                ->where('ocorrencias.user_id', '=', Auth::user()->id )
                ->where ('casos.nome', 'LIKE', '%' . $buscar . '%' )
                ->orWhere ( 'ocorrencias.resumo', 'LIKE', '%' . $buscar . '%' )
                ->orWhere ( 'especialidades.name', 'LIKE', '%' . $buscar . '%' )
                ->orWhere ( 'ocorrencias.tipo', 'LIKE', '%' . $buscar . '%' )
                ->orWhere ( 'ocorrencias.importancia', 'LIKE', '%' . $buscar . '%' )
                ->orderByDesc('data')
                ->get();

                return view('relatorio.index')
                ->with('registros',$registros )
                ->with('buscarTipo','completo')
                ->with('busca', $buscar)
                ->with('buscarDataInicial','')
                ->with('buscarDataFinal','');
            }
            else
            {
                $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->join('casos', 'casos.id', 'ocorrencias.caso_id')
                ->where('ocorrencias.user_id', '=', Auth::user()->id )
                ->whereDate('ocorrencias.data','>=', $buscarDataInicial)
                ->whereDate('ocorrencias.data','<=', $buscarDataFinal)
                ->orderByDesc('data')
                ->get();

                return view('relatorio.index')
                ->with('registros',$registros )
                ->with('buscarTipo','completo')
                ->with('busca', '')
                ->with('buscarDataInicial',$buscarDataInicial)
                ->with('buscarDataFinal',$buscarDataFinal);
            }

        }
        else
        {
            if( $buscarTipo == 'simples' )
            {
                $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->join('casos', 'casos.id', 'ocorrencias.caso_id')
                ->where('ocorrencias.user_id', '=', Auth::user()->id )
                ->orderByDesc('id')
                ->take(5)
                ->get();

                return view('relatorio.index', ['registros' => $registros])
                ->with('buscarTipo','simples')
                ->with('busca','')
                ->with('buscarDataInicial','')
                ->with('buscarDataFinal','');
            }
            else
            {
                if( $buscarTipo == 'resumido' )
                {
                    $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos')
                    ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                    ->join('casos', 'casos.id', 'ocorrencias.caso_id')
                    ->where('ocorrencias.user_id', '=', Auth::user()->id )
                    ->where('ocorrencias.importancia', '=', 'Importante' )
                    ->orderByDesc('id')
                    ->get();

                    return view('relatorio.index', ['registros' => $registros])
                    ->with('buscarTipo','resumido')
                    ->with('busca','')
                    ->with('buscarDataInicial','')
                    ->with('buscarDataFinal','');
                }
                else
                {
                    $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos')
                    ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                    ->join('casos', 'casos.id', 'ocorrencias.caso_id')
                    ->where('ocorrencias.user_id', '=', Auth::user()->id )
                    ->orderByDesc('id')
                    ->get();

                    return view('relatorio.index', ['registros' => $registros])
                    ->with('buscarTipo','completo')
                    ->with('busca','')
                    ->with('buscarDataInicial','')
                    ->with('buscarDataFinal','');
                }
            }
        }
    }

    public function relatorioImpressao( Request $request )
    {
        $campoImpressao = $request->input('campoImpressao');

        $registrosArray = json_decode($campoImpressao, true);

        $registros = collect($registrosArray)->map(function ($registroArray) {
            return (object) $registroArray;
        });

        // Calcular idade
        $idadeUser = User::selectRaw('YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(nascimento))) AS idade')
        ->where('id', '=', Auth::user()->id )
        ->get();

        $idade = '';

        foreach ($idadeUser as $item)
        {
            $idade = $item->idade;
        }

        return view('relatorio.impressao')->with('registros', $registros )->with('idade', $idade);
    }


    public function getfileTodos( Request $request )
    {
        $campoImpressao = $request->input('campoGetFiles');

        $registrosArray = json_decode($campoImpressao, true);

        $registros = collect($registrosArray)->map(function ($registroArray) {
            return (object) $registroArray;
        });

        $casosId = [];
        $ocorrenciasId = [];

        // Montando array para a select in
        foreach ( $registros as $registro )
        {
            array_push( $casosId, $registro->caso_id );
            array_push( $ocorrenciasId, $registro->id );
        }

        // Tirando id's repetidos
        $casosId = array_unique($casosId);
        $ocorrenciasId = array_unique($ocorrenciasId);

        // Carregando arquivos
        $arquivos = Arquivo::where('user_id', '=', Auth::user()->id )
        ->whereIn('caso_id', $casosId)
        ->whereIn('ocorrencia_id', $ocorrenciasId)
        ->get();

        $validarSeTemArquivos = '';

        foreach ( $arquivos as $arquivo )
        {
            $validarSeTemArquivos = $arquivo->nome;
        }

        if ( $validarSeTemArquivos == '' )
        {
            session()->flash('error', "Arquivos não encontrados!" );
            return redirect()->back();
        }
        else
        {
            // Cria e abre arquivo zip
            $zip        = new ZipArchive;
            $zipFile    = public_path().'/files/'. 'arquivosRelatorio' . '.zip';

            if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE)
            {
                foreach ( $arquivos as $arquivo )
                {
                    $caminho = public_path() .'/files/' . $arquivo->nome;
                    $zip->addFile($caminho, $arquivo->nome);
                }
            }

            // Fecha arquivo zip
            $zip->close();

            return Response()->download($zipFile, 'Arquivos' . '.zip');
        }
    }
}
