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

use PDF;
use Mail;

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
        $registrosJson = $request->input('campoImpressao');

        $registros  = $this->converterJasonParaObjetoBancoLaravel( $registrosJson );
        $idade      = $this->calcularIdadeUsuarioConectadoAuth();

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

    public function impressaoEmail( Request $request )
    {
        $emailMedico    = $request->input('email');
        $registrosJson  = $request->input('registros');

        $registros  = $this->converterJasonParaObjetoBancoLaravel( $registrosJson );
        $idade      = $this->calcularIdadeUsuarioConectadoAuth();

        // Campos desse array data, podem ser acessos pela view na função abaixo loadview do PDF
        $data["email"] = $emailMedico ;
        $data["title"] = "Relatório médico do paciente " . Auth::user()->name;
        $data["body"] = "Controle sua saúde";
        $data["registros"] = $registros;
        $data["idade"] = $idade;

        // A view abaixo não pode usar tags novas do html5 (tag section por exemplo), se usar o pdf gerado virá em branco
        $pdf = PDF::loadView('relatorio.emailAnexo', $data);

        // Testar e ver arquivo antes de anexar no email
        //return $pdf->download('pdf_file.pdf');

        // Testes antigos inicio
                //$pdf = PDF::loadView('emailPerfilExcluiu', $data);
                //$pdf = PDF::loadView('relatorio.email', compact('registros','idade'));

                // $pdf = PDF::loadHTML($html, $data);
                // $html = ob_get_contents();
                    //$pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->download('myfile.pdf');
                //  $pdf->render();
                // return $pdf;
        // Testes antigos fim

        Mail::send('relatorio.emailMensagem', $data, function($message)use($data, $pdf) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->attachData($pdf->output(), "relatorioMedico.pdf");
        });

        session()->flash('success', "Email enviado com sucesso para $emailMedico!");
        return redirect( route( 'relatorio' ) );

        //->attachData($pdf->output(), "text.pdf");
       //  ->attachData($pdf, "text.pdf");
    }

    function converterJasonParaObjetoBancoLaravel( $json )
    {
        $registrosArray = json_decode($json, true);

        $registros = collect($registrosArray)->map(function ($registroArray) {
            return (object) $registroArray;
        });

        return $registros;
    }

    function calcularIdadeUsuarioConectadoAuth()
    {
        // Calcular idade
        $idadeUser = User::selectRaw('YEAR(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(nascimento))) AS idade')
        ->where('id', '=', Auth::user()->id )
        ->get();

        $idade = '';

        foreach ($idadeUser as $item)
        {
            $idade = $item->idade;
        }

        return $idade;
    }
}
