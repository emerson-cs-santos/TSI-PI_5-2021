<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ocorrencia;
use App\Models\Caso;
use App\Models\Especialidade;
use App\Models\Arquivo;
use App\Http\Requests\CreateOcorrenciasRequest;
use App\Http\Requests\EditOcorrenciasRequest;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;
use App\Models\Tipo;

class OcorrenciasController extends Controller
{
    // Proteção para não colocar data maior que a data atual
    function validarData( String $Data): bool
    {
        $dataNovaSemFormatar = strtotime($Data);
        $dataNova = date('d-m-Y',$dataNovaSemFormatar);

        return strtotime($dataNova) > strtotime(date('d-m-Y'));
    }

    public function index( $casoId )
    {
        $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
        ->where('caso_id', '=', $casoId )
        ->where('user_id', '=', Auth::user()->id )
        ->orderByDesc('id')
        ->paginate(5);

        $caso = Caso::withTrashed()->where('id', $casoId)->firstOrFail();

        return view('ocorrencias.index', ['ocorrencias' => $ocorrencias])->with( ['casoId' => $casoId] )->with( ['caso' => $caso->nome] );
    }

    public function create( $casoId )
    {
        return view('ocorrencias.create')->with( ['casoId' => $casoId] )
        ->with('especialidades', Especialidade::orderBy('name')->get())
        ->with('tipos', Tipo::orderBy('name')->get());
    }

    public function store(CreateOcorrenciasRequest $request, $casoId)
    {
      $files = $request->allFiles(); // Carrega todos os arquivos enviados

      if ( !empty($files) ) // Apenas verifica/considera os arquivos se tem algum enviado
      {
        if ( $this->validFiles( $files['arquivo'] ) == false ) // Valida se extensão dos arquivos são aceitas
        {
          return redirect()->back();
        }
      }

      $DataNova = $request->data;
      if ( $this->validarData( $DataNova ) )
      {
        $DataNova = date('d/m/Y', strtotime($DataNova)) ;
        session()->flash('error', "Data informada: $DataNova é maior que a data de hoje: " . date('d/m/Y'));
        return redirect()->back();
      }

        if ( empty($request->local) )
        {
            $request->local = ' ';
        }

        if ( empty($request->medico) )
        {
            $request->medico = ' ';
        }

        if ( empty($request->crm) )
        {
            $request->crm = ' ';
        }

        if ( empty($request->receitas) )
        {
            $request->receitas = ' ';
        }

        if ( empty($request->desc) )
        {
            $request->desc = ' ';
        }

        $ocorrencia = Ocorrencia::create([
            'user_id'           => Auth::user()->id
            ,'caso_id'          => $casoId
            ,'especialidade_id' => $request->especialidade_id
            ,'tipo_id'          => $request->tipo_id
            ,'data'             => $request->data
            ,'importancia'      => $request->importancia
            ,'resumo'           => $request->resumo
            ,'local'            => $request->local
            ,'medico'           => $request->medico
            ,'crm'              => $request->crm
            ,'receitas'         => $request->receitas
            ,'desc'             => $request->desc
        ]);

        if ( !empty($files) ) // Apenas verifica/considera os arquivos se tem algum enviado
        {
          $this->storeFiles( $files['arquivo'], $casoId, $ocorrencia->id ); // Upload dos arquivos
        }

       session()->flash('success', 'Ocorrência criada com sucesso!');

        return redirect( route( 'Ocorrencias.index', $casoId ) );
    }

    public function show( $casoId, $ocorrenciaId )
    {
        $ocorrencia = Ocorrencia::withTrashed()->where('id', $ocorrenciaId)->where('caso_id', $casoId)->where('user_id', '=', Auth::user()->id )->firstOrFail();

        $arquivos = Arquivo::where('user_id', '=', Auth::user()->id )
        ->where('caso_id', $casoId)
        ->where('ocorrencia_id', $ocorrenciaId)
        ->get();

        return view('ocorrencias.show')
        ->with( ['casoId' => $casoId] )
        ->with('ocorrencia', $ocorrencia)
        ->with('especialidades', Especialidade::orderBy('name')->get() )
        ->with('tipos', Tipo::orderBy('name')->get())
        ->with('arquivos', $arquivos);
    }


    public function edit( $casoId, $ocorrenciaId )
    {
        $ocorrencia = Ocorrencia::withTrashed()->where('id', $ocorrenciaId)->where('caso_id', $casoId)->where('user_id', '=', Auth::user()->id )->firstOrFail();

        $arquivos = Arquivo::where('user_id', '=', Auth::user()->id )
        ->where('caso_id', $casoId)
        ->where('ocorrencia_id', $ocorrenciaId)
        ->get();

        return view('ocorrencias.edit')
        ->with( ['casoId' => $casoId] )
        ->with('ocorrencia', $ocorrencia)
        ->with('especialidades', Especialidade::orderBy('name')->get() )
        ->with('tipos', Tipo::orderBy('name')->get())
        ->with('arquivos', $arquivos);
    }


    public function update( EditOcorrenciasRequest $request, $casoId, $ocorrenciaId )
    {
        $files = $request->allFiles(); // Carrega todos os arquivos enviados

        if ( !empty($files) ) // Apenas verifica/considera os arquivos se tem algum enviado
        {
          if ( $this->validFiles( $files['arquivo'] ) == false ) // Valida se extensão dos arquivos são aceitas
          {
            return redirect()->back();
          }
        }

        $DataNova = $request->data;
        if ( $this->validarData( $DataNova ) )
        {
          $DataNova = date('d/m/Y', strtotime($DataNova)) ;
          session()->flash('error', "Data informada: $DataNova é maior que a data de hoje: " . date('d/m/Y'));
          return redirect()->back();
        }

        $ocorrencia = Ocorrencia::withTrashed()->where('id', $ocorrenciaId)->where('caso_id', $casoId)->firstOrFail();

        if ( empty($request->local) )
        {
            $request->local = ' ';
        }

        if ( empty($request->medico) )
        {
            $request->medico = ' ';
        }

        if ( empty($request->crm) )
        {
            $request->crm = ' ';
        }

        if ( empty($request->receitas) )
        {
            $request->receitas = ' ';
        }

        if ( empty($request->desc) )
        {
            $request->desc = ' ';
        }

        $ocorrencia->update([
            'user_id'           => Auth::user()->id
            ,'caso_id'          => $casoId
            ,'especialidade_id' => $request->especialidade_id
            ,'tipo_id'          => $request->tipo_id
            ,'data'             => $request->data
            ,'importancia'      => $request->importancia
            ,'resumo'           => $request->resumo
            ,'local'            => $request->local
            ,'medico'           => $request->medico
            ,'crm'              => $request->crm
            ,'receitas'         => $request->receitas
            ,'desc'             => $request->desc
        ]);

        if ( !empty($files) ) // Apenas verifica/considera os arquivos se tem algum enviado
        {
          $this->storeFiles( $files['arquivo'], $casoId, $ocorrencia->id ); // Upload dos arquivos
        }

        session()->flash('success', 'Ocorrência alterada com sucesso!');
        return redirect( route( 'Ocorrencias.index', $casoId) );
    }

    public function destroy( $casoId, $ocorrenciaId )
    {
        $ocorrencia = Ocorrencia::withTrashed()->where('id', $ocorrenciaId)->where('caso_id', $casoId)->where('user_id', '=', Auth::user()->id )->firstOrFail();

        if($ocorrencia->trashed())
        {
            $ocorrencia->forceDelete();
            session()->flash('success', 'Ocorrência removida com sucesso!');
        }
        else
        {
            $ocorrencia->delete();
            session()->flash('success', 'Ocorrência movida para lixeira com sucesso!');
        }
        return redirect()->back();
    }


    public function restore( $casoId, $ocorrenciaId )
    {
        $ocorrencia = Ocorrencia::withTrashed()->where('id', $ocorrenciaId)->where('caso_id', $casoId)->firstOrFail();
        $ocorrencia->restore();

        session()->flash('success', 'Ocorrência ativada com sucesso!');
        return redirect()->back();
    }


    public function trashed( $casoId )
    {
        $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')->onlyTrashed()
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
        ->where('caso_id', '=', $casoId )
        ->where('user_id', '=', Auth::user()->id )
        ->orderByDesc('id')
        ->paginate(5);

        $caso = Caso::withTrashed()->where('id', $casoId)->firstOrFail();

        return view('ocorrencias.index', ['ocorrencias' => $ocorrencias])->with( ['casoId' => $casoId] )->with( ['caso' => $caso->nome] );
    }

    public function buscar(Request $request, $casoId)
    {
        $caso = Caso::withTrashed()->where('id', $casoId)->firstOrFail();

        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')
            ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
            ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
            ->where('user_id', '=', Auth::user()->id )
            ->where('caso_id', '=', $casoId )
            ->where ( 'tipos.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'ocorrencias.id', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'ocorrencias.importancia', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'especialidades.name', 'LIKE', '%' . $buscar . '%' )
            ->orderByDesc('data')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $ocorrencias->appends ( array ('busca' => $request->input('busca')  ) );

            return view('ocorrencias.index')
            ->with('ocorrencias',$ocorrencias )->withQuery ( $buscar )
            ->with( ['casoId' => $casoId] )
            ->with( ['caso' => $caso->nome] )
            ->with('busca',$buscar);

        }
        else
        {
            $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')
            ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
            ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
            ->where('user_id', '=', Auth::user()->id )
            ->where('caso_id', '=', $casoId )
            ->orderByDesc('data')
            ->paginate(5)
            ->setPath ( '' );

            return view('ocorrencias.index')
            ->with('ocorrencias', $ocorrencias )
            ->with( ['casoId' => $casoId] )
            ->with( ['caso' => $caso->nome] )
            ->with('busca','');
        }
    }


    public function buscarData(Request $request, $casoId)
    {
        $caso = Caso::withTrashed()->where('id', $casoId)->firstOrFail();

        $buscarDataInicial = $request->input('dataInicial');

        $buscarDataFinal = $request->input('dataFinal');

        if( $buscarDataInicial != "" or $buscarDataFinal != "" )
        {
            if( $buscarDataInicial != "" and $buscarDataFinal != "" )
            {
                $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
                ->where('user_id', '=', Auth::user()->id )
                ->where('caso_id', '=', $casoId )
                ->whereDate('ocorrencias.data','>=', $buscarDataInicial)
                ->whereDate('ocorrencias.data','<=', $buscarDataFinal)
                ->orderByDesc('data')
                ->paginate(30)
                ->setPath ( '' );

                $pagination = $ocorrencias->appends ( array ('buscarDataInicial' => $request->input('buscarDataInicial')  ) );
                $pagination = $ocorrencias->appends ( array ('buscarDataFinal' => $request->input('buscarDataFinal')  ) );

                return view('ocorrencias.index')
                ->with('ocorrencias',$ocorrencias )->withQuery ( $buscarDataInicial )
                ->with( ['casoId' => $casoId] )
                ->with( ['caso' => $caso->nome] )
                ->with('buscarDataInicial',$buscarDataInicial)
                ->with('buscarDataFinal',$buscarDataFinal);
            }

            if( empty($buscarDataInicial) and $buscarDataFinal != "" )
            {
                $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
                ->where('user_id', '=', Auth::user()->id )
                ->where('caso_id', '=', $casoId )
                ->whereDate('ocorrencias.data','<=', $buscarDataFinal)
                ->orderByDesc('data')
                ->paginate(30)
                ->setPath ( '' );

                $pagination = $ocorrencias->appends ( array ('buscarDataFinal' => $request->input('buscarDataFinal')  ) );

                return view('ocorrencias.index')
                ->with('ocorrencias',$ocorrencias )->withQuery ( $buscarDataFinal )
                ->with( ['casoId' => $casoId] )
                ->with( ['caso' => $caso->nome] )
                ->with('buscarDataInicial',$buscarDataInicial)
                ->with('buscarDataFinal',$buscarDataFinal);
            }

            if( $buscarDataInicial != "" and empty($buscarDataFinal)  )
            {
                $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
                ->where('user_id', '=', Auth::user()->id )
                ->where('caso_id', '=', $casoId )
                ->whereDate('ocorrencias.data','>=', $buscarDataInicial)
                ->orderByDesc('data')
                ->paginate(30)
                ->setPath ( '' );

                $pagination = $ocorrencias->appends ( array ('buscarDataInicial' => $request->input('buscarDataInicial')  ) );

                return view('ocorrencias.index')
                ->with('ocorrencias',$ocorrencias )->withQuery ( $buscarDataInicial )
                ->with( ['casoId' => $casoId] )
                ->with( ['caso' => $caso->nome] )
                ->with('buscarDataInicial',$buscarDataInicial)
                ->with('buscarDataFinal',$buscarDataFinal);
            }

        }
        else
        {
            $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade, tipos.name as tipo, tipos.color as cor')
            ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
            ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
            ->where('user_id', '=', Auth::user()->id )
            ->where('caso_id', '=', $casoId )
            ->orderByDesc('data')
            ->paginate(30)
            ->setPath ( '' );

            return view('ocorrencias.index')
            ->with('ocorrencias', $ocorrencias )
            ->with( ['casoId' => $casoId] )
            ->with( ['caso' => $caso->nome] )
            ->with('buscarDataInicial','')
            ->with('buscarDataFinal','');
        }
    }

    function storeFiles( $arquivos, int $casoId, int $ocorrenciaId )
    {
        foreach ($arquivos as $arquivo)
        {
            // Nome original do arquivo
            $FileName = $arquivo->getClientOriginalName();

            // Extensão
            $extension = $arquivo->extension();

            // Definir nome único
            $name = uniqid() . '_' . strtotime(date('d-m-Y H:i:s')) . '_' . $FileName;

            // Salvar/upload arquivo no servidor
            $arquivo->move(public_path().'/files/', $name);

            // Salvar no banco
            Arquivo::create([
                'user_id'           => Auth::user()->id
                ,'caso_id'          => $casoId
                ,'ocorrencia_id'    => $ocorrenciaId
                ,'nome'             => $name
                ,'extensao'         => $extension
            ]);
        }
    }

    function validFiles( $arquivos ): bool
    {
        $retorno = true;

        foreach ($arquivos as $arquivo)
        {
            $extension = $arquivo->extension();

            // validar tipo,apenas aceitar pdf, doc e docx ou imagem
            if ( $extension !== 'pdf' and $extension !== 'doc' and $extension !== 'docx' and !exif_imagetype($arquivo) )
            {
              session()->flash('error', "Tipo do arquivo: $extension inválido, extensões aceitas: PDF, DOC, DOCX ou imagens." );
              $retorno = false;
            }
        }
        return $retorno;
    }

    public function getfile( int $casoId, int $ocorrenciaId, string $nomeArquivo )
    {
        //$file=Storage::disk('public')->get('/files/' .$nomeArquivo);
        // return ( new Response($file, 200) );

        //$headers = array('Content-Type: image/jpg');
        //  return Response()->download($file, 'teste.jpg', $headers);

        // Validando se o arquivo pertence ao usuário, caso e ocorrencia
        $arquivos = Arquivo::where('user_id', '=', Auth::user()->id )
        ->where('caso_id', $casoId)
        ->where('ocorrencia_id', $ocorrenciaId)
        ->where('nome', $nomeArquivo )
        ->get();

        $nomeArquivoBaixar = '';

        foreach ( $arquivos as $arquivo )
        {
            $nomeArquivoBaixar = $arquivo->nome;
        }

        if ( $nomeArquivoBaixar == '' )
        {
            session()->flash('error', "Arquivo não encontrado!" );
            return redirect()->back();
        }
        else
        {

            $file = public_path() .'/files/' . $nomeArquivoBaixar;
            return Response()->download($file, $nomeArquivoBaixar);
        }
    }

    public function getfileTodos( int $casoId, int $ocorrenciaId )
    {
        $arquivos = Arquivo::where('user_id', '=', Auth::user()->id )
        ->where('caso_id', $casoId)
        ->where('ocorrencia_id', $ocorrenciaId)
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
            $zipFile    = public_path().'/files/'. 'arquivos_' . uniqid() . '.zip';

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

            return Response()->download($zipFile, 'Arquivos_' . uniqid() . '.zip');
        }
    }

    public function deletefile( int $casoId, int $ocorrenciaId, string $nomeArquivo )
    {
        // Validando se o arquivo pertence ao usuário, caso e ocorrencia
        $arquivos = Arquivo::where('user_id', '=', Auth::user()->id )
        ->where('caso_id', $casoId)
        ->where('ocorrencia_id', $ocorrenciaId)
        ->where('nome', $nomeArquivo )
        ->get();

        $nomeArquivoBaixar = '';

        foreach ( $arquivos as $arquivo )
        {
            $nomeArquivoBaixar = $arquivo->nome;
        }

        if ( $nomeArquivoBaixar == '' )
        {
            session()->flash('error', "Arquivo não encontrado!" );
            return redirect()->back();
        }
        else
        {
            // Apagar do banco
            foreach ( $arquivos as $arquivo )
            {
                $arquivo->delete();
            }

            // Apagar arquivo
            $file = public_path() .'/files/' . $nomeArquivoBaixar;
            File::delete($file);

            session()->flash('success', 'Arquivo apagado com sucesso!');
            return redirect()->back();
        }

        // Se for usar, para apagar multiplos arquivos
        // File::delete($file1, $file2, $file3);
        // ou
        // $files = array($file1, $file2);
        // File::delete($files);
    }
}
