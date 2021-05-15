<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use App\Models\Ocorrencia;
use App\Http\Requests\CreateCasosRequest;
use App\Http\Requests\EditCasosRequest;
use Illuminate\Support\Facades\Auth;

class CasosController extends Controller
{
    public function index()
    {
        $casos = Caso::selectRaw('casos.*')->where('user_id', '=', Auth::user()->id )->orderBy('nome')->get();

        return view('casos.index', ['casos' => $casos] )->with( ['status_Buscado' => 'todos'] );
    }

    public function create()
    {
        return view('casos.create');
    }


    public function store(CreateCasosRequest $request)
    {

        if ( empty($request->medicamentos) )
        {
            $request->medicamentos = ' ';
        }

        Caso::create([
            'user_id'       => Auth::user()->id
            ,'nome'         => $request->nome
            ,'desc'         => $request->descricao
            ,'status'       => $request->status
            ,'medicamentos' => $request->medicamentos
        ]);

       session()->flash('success', 'Caso criado com sucesso!');

        return redirect(route('Casos.index'));
    }


    public function show( $id )
    {
        $caso = Caso::withTrashed()->where('id', $id)->firstOrFail();

        return view('casos.show')->with('caso', $caso);
    }


    public function edit( $id )
    {
        $caso = Caso::withTrashed()->where('id', $id)->firstOrFail();

        return view('casos.edit')->with('caso', $caso);
    }


    public function update( EditCasosRequest $request, $id )
    {
        $caso = Caso::withTrashed()->where('id', $id)->firstOrFail();

        if ( empty($request->medicamentos) )
        {
            $request->medicamentos = ' ';
        }

        $caso->update([
            'user_id'       => Auth::user()->id
            ,'nome'         => $request->nome
            ,'desc'         => $request->descricao
            ,'status'       => $request->status
            ,'medicamentos' => $request->medicamentos
        ]);

        session()->flash('success', 'Caso alterado com sucesso!');
        return redirect(route('Casos.index'));
    }


    public function destroy($id)
    {
        $caso = Caso::withTrashed()->where('id', $id)->firstOrFail();

        if( $caso->trashed() )
        {
            // Apagar todas as ocorrencias do caso
            $ocorrenciasApagar = Ocorrencia::withTrashed()
                ->where('user_id', Auth::user()->id )
                ->where('caso_id', $id )
                ->get();

            foreach ($ocorrenciasApagar as $ocorrenciaApagar)
            {
                $ocorrenciaApagar->forceDelete();
            }

            $caso->forceDelete();
            session()->flash('success', 'Caso removido com sucesso!');
        }
        else
        {
            $caso->delete();
            session()->flash('success', 'Caso movido para lixeira com sucesso!');
        }
        return redirect()->back();
    }

    public function trashed()
    {
        $casos = Caso::selectRaw('casos.*')->onlyTrashed()->where('user_id', '=', Auth::user()->id )->orderBy('nome')->get();
        return view('casos.index', ['casos' => $casos])->with( ['status_Buscado' => 'todos'] );
    }

    public function restore($id)
    {
        $caso = Caso::withTrashed()->where('id', $id)->firstOrFail();
        $caso->restore();
        session()->flash('success', 'Caso ativado com sucesso!');
        return redirect()->back();
    }

    public function buscarTrashed(Request $request)
    {
        $nome       = $request->input('nome');
        $status     = $request->input('status');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres ou joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo campos e joins
        $casos = Caso::selectRaw('casos.*')->onlyTrashed()->join('users', 'users.id', 'casos.user_id')->where('user_id', '=', Auth::user()->id );

        // Definindo Wheres
            // Nome
            if ( !empty($nome) )
            {
                $casos = $casos->where('casos.nome', 'LIKE', '%' . $nome . '%');
            }

            // Status
            if ( !empty($status) and $status !== 'todos' )
            {
                $casos = $casos->where('casos.status', $status);
            }

        // Definindo ordem
        $casos = $casos->orderBy('nome');

        // Após definir todos os joins, where etc, executa a select
        $casos = $casos->get();

        // Retornar View com registros e buscas aplicadas
        return view('casos.index')
        ->with('casos', $casos )
        ->with('nome_Buscado',$nome)
        ->with( ['status_Buscado' => $status] );
    }

    public function buscar(Request $request)
    {
        $nome       = $request->input('nome');
        $status     = $request->input('status');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres ou joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo campos e joins e wheres da select que são fixas
        $casos = Caso::selectRaw('casos.*')->join('users', 'users.id', 'casos.user_id')->where('user_id', '=', Auth::user()->id );

        // Definindo Wheres
            // Nome
            if ( !empty($nome) )
            {
                $casos = $casos->where('casos.nome', 'LIKE', '%' . $nome . '%');
            }

            // Status
            if ( !empty($status) and $status !== 'todos' )
            {
                $casos = $casos->where('casos.status', $status);
            }

        // Definindo ordem
        $casos = $casos->orderBy('nome');

        // Após definir todos os joins, where etc, executa a select
        $casos = $casos->get();

        // Retornar View com registros e buscas aplicadas
        return view('casos.index')
        ->with('casos', $casos )
        ->with('nome_Buscado',$nome)
        ->with( ['status_Buscado' => $status] );
    }
}
