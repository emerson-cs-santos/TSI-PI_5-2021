<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo;
use App\Http\Requests\CreateTiposRequest;
use App\Http\Requests\EditTiposRequest;

class TiposController extends Controller
{
    public function index()
    {
        $Tipos = $this->indexBanco();
        return view('tipos.index', ['tipos' => $Tipos]);
    }

    public function indexBanco()
    {
        $Tipos = Tipo::selectRaw('tipos.*')->orderByDesc('id')->get();
        return $Tipos;
    }

    public function create()
    {
        return view('tipos.create');
    }

    public function store(CreateTiposRequest $request)
    {
        Tipo::create([
            'name'  => $request->name
            ,'color'  => $request->color
        ]);

       session()->flash('success', 'Tipo criado com sucesso!');

        return redirect(route('Tipos.index'));
    }

    public function show($id)
    {
        $tipo = Tipo::withTrashed()->where('id', $id)->firstOrFail();

        return view('tipos.show')->with('tipo', $tipo);
    }

    public function edit($id)
    {
        $tipo = Tipo::withTrashed()->where('id', $id)->firstOrFail();

        return view('tipos.edit')->with('tipo', $tipo);
    }

    public function update(EditTiposRequest $request, $id)
    {
        $tipo = Tipo::withTrashed()->where('id', $id)->firstOrFail();

        $tipo->update([
            'name'  => $request->name
            ,'color'  => $request->color
        ]);

        session()->flash('success', 'Tipo alterado com sucesso!');
        return redirect(route('Tipos.index'));
    }

    public function destroy($id)
    {
        $tipo = Tipo::withTrashed()->where('id', $id)->firstOrFail();

        // Validar se Especialidade está sendo utilizado em alguma ocorrencia, se tiver, não pode excluir

        $qtdOcorrencias = $tipo->ocorrencias()->count();

        if( $qtdOcorrencias > 0 )
        {
            session()->flash('error', "Existem $qtdOcorrencias Ocorrências com esse tipo!");
            return redirect()->back();
        }

        if($tipo->trashed())
        {
            $tipo->forceDelete();
            session()->flash('success', 'Tipo removido com sucesso!');
        }
        else
        {
            $tipo->delete();
            session()->flash('success', 'Tipo movido para lixeira com sucesso!');
        }
        return redirect()->back();
    }

    public function trashed()
    {
        $tipos = Tipo::selectRaw('tipos.*')->onlyTrashed()->orderByDesc('id')->get();
        return view('tipos.index', ['tipos' => $tipos]);
    }

    public function restore($id)
    {
        $especialidade = Tipo::withTrashed()->where('id', $id)->firstOrFail();
        $especialidade->restore();
        session()->flash('success', 'Tipo ativado com sucesso!');
        return redirect()->back();
    }

    public function buscarTrashed(Request $request)
    {
        $codigo = $request->input('codigo');
        $nome   = $request->input('nome');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres ou joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo campos e joins e wheres da select que são fixas
        $tipos = Tipo::selectRaw('tipos.*')->onlyTrashed();

        // Definindo Wheres
            // Código
            if ( !empty($codigo) )
            {
                $tipos = $tipos->where('tipos.id', 'LIKE', '%' . $codigo . '%');
            }

            // Nome
            if ( !empty($nome) )
            {
                $tipos = $tipos->where('tipos.name', 'LIKE', '%' . $nome . '%');
            }

        // Definindo ordem
        $tipos = $tipos->orderBy('name');

        // Após definir todos os joins, where etc, executa a select
        $tipos = $tipos->get();

        // Retornar View com registros e buscas aplicadas
        return view('tipos.index')
        ->with('tipos', $tipos )
        ->with('codigo_Buscado',$codigo)
        ->with( ['nome_Buscado' => $nome] );
    }

    public function buscar(Request $request)
    {
        $codigo = $request->input('codigo');
        $nome   = $request->input('nome');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres ou joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo campos e joins e wheres da select que são fixas
        $tipos = Tipo::selectRaw('tipos.*');

        // Definindo Wheres
            // Código
            if ( !empty($codigo) )
            {
                $tipos = $tipos->where('tipos.id', 'LIKE', '%' . $codigo . '%');
            }

            // Nome
            if ( !empty($nome) )
            {
                $tipos = $tipos->where('tipos.name', 'LIKE', '%' . $nome . '%');
            }

        // Definindo ordem
        $tipos = $tipos->orderBy('name');

        // Após definir todos os joins, where etc, executa a select
        $tipos = $tipos->get();

        // Retornar View com registros e buscas aplicadas
        return view('tipos.index')
        ->with('tipos', $tipos )
        ->with('codigo_Buscado',$codigo)
        ->with( ['nome_Buscado' => $nome] );
    }

}
