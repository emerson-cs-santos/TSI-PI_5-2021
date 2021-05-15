<?php

namespace App\Http\Controllers;
use App\Models\Ocorrencia;
use App\Models\Caso;
use App\Models\Especialidade;
use App\Models\User;
use App\Models\arquivo;
use App\Models\Tipo;
use ZipArchive;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use PDF;
use Mail;

class RelatorioController extends Controller
{
    function formatarData( string $Data ): string
    {
        return date($Data);
    }

    public function relatorio()
    {
        $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos, tipos.name as tipo, tipos.color as cor')
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
        ->join('casos', 'casos.id', 'ocorrencias.caso_id')
        ->where('ocorrencias.user_id', '=', Auth::user()->id )
        ->orderByDesc('casos.id')
        ->orderByDesc('ocorrencias.id')
        ->take(5)
        ->get();

        return view('relatorio.index', ['registros' => $registros])
        ->with('buscarTipo','simples')
        ->with('especialidades', Especialidade::orderBy('name')->get() )
        ->with('tipos', Tipo::orderBy('name')->get())
        ->with( ['tipo_idBuscado' => 'todos'] )
        ->with( ['importancia_Buscado' => 'todos'] )
        ->with( ['especialidade_idBuscado' => 'todos'] )
        ->with( ['resumo_Buscado' => ''] )
        ->with( ['caso_Buscado' => ''] )
        ->with( ['status_Buscado' => 'todos'] );
    }

    public function relatorioBuscar( Request $request )
    {
        $buscarTipo         = $request->input('tipo');
        $tipo_id            = $request->input('tipo_id');
        $importancia        = $request->input('importancia');
        $especialidade_id   = $request->input('especialidade_id');
        $caso               = $request->input('caso');
        $status             = $request->input('status');
        $resumo             = $request->input('resumo');
        $buscarDataInicial  = $request->input('dataInicial');
        $buscarDataFinal    = $request->input('dataFinal');

        // Definindo campos e joins
        $registros = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, casos.nome as caso, casos.desc as casoDesc, casos.status as status, casos.medicamentos as medicamentos, tipos.name as tipo, tipos.color as cor')
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
        ->join('casos', 'casos.id', 'ocorrencias.caso_id');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres ou joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo Wheres
            // Usuário
            $registros = $registros->where('ocorrencias.user_id', '=', Auth::user()->id );

            // Tipo da ocorrência
            if ( !empty($tipo_id) and $tipo_id !== 'todos' )
            {
                $registros = $registros->where('ocorrencias.tipo_id', $tipo_id);
            }

            // Relevância da ocorrência
            if ( !empty($importancia) and $importancia !== 'todos' )
            {
                $registros = $registros->where('ocorrencias.importancia', $importancia);
            }

            // Especialidade da ocorrência
            if ( !empty($especialidade_id) and $especialidade_id !== 'todos'  )
            {
                $registros = $registros->where('ocorrencias.especialidade_id', $especialidade_id);
            }

            // Nome do Caso
            if ( !empty($caso) )
            {
                $registros = $registros->where('casos.nome', 'LIKE', '%' . $caso . '%');
            }

            // Status do Caso
            if ( !empty($status) and $status !== 'todos' )
            {
                $registros = $registros->where('casos.status', $status);
            }

            // Resumo da ocorrência
            if ( !empty($resumo) )
            {
                $registros = $registros->where('ocorrencias.resumo', 'LIKE', '%' . $resumo . '%');
            }

            // Data inicial da ocorrência
            if ( !empty($buscarDataInicial) )
            {
                $registros = $registros->whereDate('ocorrencias.data','>=', $this->formatarData( $buscarDataInicial ) );
            }

            // Data final da ocorrência
            if ( !empty($buscarDataFinal) )
            {
                $registros = $registros->whereDate('ocorrencias.data','<=', $this->formatarData( $buscarDataFinal ) );
            }

        // Definindo ordem
        $registros = $registros->orderByDesc('casos.id') ->orderByDesc('ocorrencias.id');

        // Modo simples apenas carrega os 5 primeiros registros
        if ( $buscarTipo == 'simples' )
        {
            $registros = $registros->take(5);
        }

        // Após definir todos os joins, where etc, executa a select
       // DB::enableQueryLog();
        $registros = $registros->get();
      //  $quries = DB::getQueryLog();
       // dd($quries);

       // Retornar View com registros e buscas aplicadas
        return view('relatorio.index', ['registros' => $registros])
        ->with('especialidades', Especialidade::orderBy('name')->get() )
        ->with('tipos', Tipo::orderBy('name')->get())
        ->with('buscarTipo',$buscarTipo)
        ->with( ['tipo_idBuscado' => $tipo_id] )
        ->with( ['importancia_Buscado' => $importancia] )
        ->with( ['especialidade_idBuscado' => $especialidade_id] )
        ->with( ['resumo_Buscado' => $resumo] )
        ->with( ['caso_Buscado' => $caso] )
        ->with( ['status_Buscado' => $status] )
        ->with('buscarDataInicial',$buscarDataInicial)
        ->with('buscarDataFinal',$buscarDataFinal);
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
        $arquivos = arquivo::where('user_id', '=', Auth::user()->id )
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
            $zipFile    = public_path().'/files/'. 'arquivosRelatorio_' . uniqid() . '.zip';

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

            return Response()->download($zipFile, 'arquivosrelatorio_' . uniqid() . '.zip');
        }
    }

    public function impressaoEmail( Request $request )
    {
        $emailMedico    = $request->input('email');
        $registrosJson  = $request->input('registros');

        $registros  = $this->converterJasonParaObjetoBancoLaravel( $registrosJson );
        $idade      = $this->calcularIdadeUsuarioConectadoAuth();

        // Campos desse array data, podem ser acessos pela view na função abaixo loadview do PDF
        $data["email"] = $emailMedico;

        // Definindo preposição para se adequar ao nome do paciente se é masculino ou feminimo
        $preposicao = '';

        if ( Auth::user()->genero == 'Feminino' )
        {
            $preposicao = 'da';
        }
        else
        {
            $preposicao = 'do';
        }

        $data["title"] = "Relatório médico $preposicao paciente " . Auth::user()->name;
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
