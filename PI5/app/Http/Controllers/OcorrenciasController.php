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

    public function store(CreateOcorrenciasRequest $request, $casoId)
    {
       // Proteção para não colocar data maior que a data atual
       $dataNovaSemFormatar = strtotime($request->data);
       $dataNova = date('d-m-Y',$dataNovaSemFormatar);

      if (  $dataNova > date('d/m/Y') )
      {
           session()->flash('error', "Data informada: $dataNova é maior que a data de hoje: " . date('d/m/Y'));
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

        Ocorrencia::create([
            'user_id'           => Auth::user()->id
            ,'caso_id'          => $casoId
            ,'especialidade_id' => $request->especialidade_id
            ,'tipo'             => $request->tipo
            ,'data'             => $request->data
            ,'importancia'      => $request->importancia
            ,'resumo'           => $request->resumo
            ,'local'            => $request->local
            ,'medico'           => $request->medico
            ,'crm'              => $request->crm
            ,'receitas'         => $request->receitas
            ,'desc'             => $request->desc
        ]);

       session()->flash('success', 'Ocorrência criada com sucesso!');

        return redirect( route( 'Ocorrencias.index', $casoId ) );
    }

    public function show( $casoId, $ocorrenciaId )
    {
        $ocorrencia = Ocorrencia::withTrashed()->where('id', $ocorrenciaId)->where('caso_id', $casoId)->where('user_id', '=', Auth::user()->id )->firstOrFail();

        return view('ocorrencias.show')->with( ['casoId' => $casoId] )->with('ocorrencia', $ocorrencia)->with('especialidades', Especialidade::orderBy('name')->get() );
    }


    public function edit( $casoId, $ocorrenciaId )
    {
        $ocorrencia = Ocorrencia::withTrashed()->where('id', $ocorrenciaId)->where('caso_id', $casoId)->where('user_id', '=', Auth::user()->id )->firstOrFail();

        return view('ocorrencias.edit')->with( ['casoId' => $casoId] )->with('ocorrencia', $ocorrencia)->with('especialidades', Especialidade::orderBy('name')->get() );
    }


    public function update( EditOcorrenciasRequest $request, $casoId, $ocorrenciaId )
    {
       // Proteção para não colocar data maior que a data atual
        $dataNovaSemFormatar = strtotime($request->data);
        $dataNova = date('d-m-Y',$dataNovaSemFormatar);

       if (  $dataNova > date('d/m/Y') )
       {
            session()->flash('error', "Data informada: $dataNova é maior que a data de hoje: " . date('d/m/Y'));
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
            ,'tipo'             => $request->tipo
            ,'data'             => $request->data
            ,'importancia'      => $request->importancia
            ,'resumo'           => $request->resumo
            ,'local'            => $request->local
            ,'medico'           => $request->medico
            ,'crm'              => $request->crm
            ,'receitas'         => $request->receitas
            ,'desc'             => $request->desc
        ]);

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
        $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')->onlyTrashed()
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
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
            $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')
            ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
            ->where('user_id', '=', Auth::user()->id )
            ->where('caso_id', '=', $casoId )
            ->where ( 'ocorrencias.tipo', 'LIKE', '%' . $buscar . '%' )
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
            $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')
            ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
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
                $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->where('user_id', '=', Auth::user()->id )
                ->where('caso_id', '=', $casoId )
                ->whereDate('ocorrencias.data','>=', $buscarDataInicial)
                ->whereDate('ocorrencias.data','<=', $buscarDataFinal)
                ->orderByDesc('data')
                ->paginate(15)
                ->setPath ( '' );

                $pagination = $ocorrencias->appends ( array ('buscarDataInicial' => $request->input('buscarDataInicial') . $request->input('buscarDataFinal')  ) );

                return view('ocorrencias.index')
                ->with('ocorrencias',$ocorrencias )->withQuery ( $buscarDataInicial )
                ->with( ['casoId' => $casoId] )
                ->with( ['caso' => $caso->nome] )
                ->with('buscarDataInicial',$buscarDataInicial)
                ->with('buscarDataFinal',$buscarDataFinal);
            }

            if( empty($buscarDataInicial) and $buscarDataFinal != "" )
            {
                $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->where('user_id', '=', Auth::user()->id )
                ->where('caso_id', '=', $casoId )
                ->whereDate('ocorrencias.data','<=', $buscarDataFinal)
                ->orderByDesc('data')
                ->paginate(15)
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
                $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')
                ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
                ->where('user_id', '=', Auth::user()->id )
                ->where('caso_id', '=', $casoId )
                ->whereDate('ocorrencias.data','>=', $buscarDataInicial)
                ->orderByDesc('data')
                ->paginate(15)
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
            $ocorrencias = Ocorrencia::selectRaw('ocorrencias.*, especialidades.name as especialidade')
            ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
            ->where('user_id', '=', Auth::user()->id )
            ->where('caso_id', '=', $casoId )
            ->orderByDesc('data')
            ->paginate(15)
            ->setPath ( '' );

            return view('ocorrencias.index')
            ->with('ocorrencias', $ocorrencias )
            ->with( ['casoId' => $casoId] )
            ->with( ['caso' => $caso->nome] )
            ->with('buscarDataInicial','')
            ->with('buscarDataFinal','');
        }
    }
}
