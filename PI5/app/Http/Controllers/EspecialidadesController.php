<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;
use App\Models\Ocorrencia;
use App\Http\Requests\CreateEspecialidadesRequest;
use App\Http\Requests\EditEspecialidadesRequest;

class EspecialidadesController extends Controller
{
    public function index()
    {
        $especialidades = $this->indexBanco();

        return view('especialidades.index', ['especialidades' => $especialidades]);
    }

    public function indexBanco()
    {
        $especialidades = Especialidade::selectRaw('especialidades.*')->orderBy('name')->get();
        return $especialidades;
    }


    public function create()
    {
        return view('especialidades.create');
    }


    public function store(CreateEspecialidadesRequest $request)
    {
        Especialidade::create([
            'name'  => $request->name
        ]);

       session()->flash('success', 'Especialidade criada com sucesso!');

        return redirect(route('Especialidades.index'));
    }


    public function show( $id )
    {
        $especialidade = Especialidade::withTrashed()->where('id', $id)->firstOrFail();

        return view('especialidades.show')->with('especialidade', $especialidade);
    }


    public function edit( $id )
    {
        $especialidade = Especialidade::withTrashed()->where('id', $id)->firstOrFail();

        return view('especialidades.edit')->with('especialidade', $especialidade);
    }


    public function update( EditEspecialidadesRequest $request, $id )
    {
        $especialidade = Especialidade::withTrashed()->where('id', $id)->firstOrFail();

        $especialidade->update([
            'name'  => $request->name
        ]);

        session()->flash('success', 'Especialidade alterada com sucesso!');
        return redirect(route('Especialidades.index'));
    }

    public function destroy($id)
    {
        $especialidade = Especialidade::withTrashed()->where('id', $id)->firstOrFail();

        // Validar se Especialidade está sendo utilizado em alguma ocorrencia, se tiver, não pode excluir

        $qtdOcorrencias = $especialidade->ocorrencias()->count();

        if( $qtdOcorrencias > 0 )
        {
            session()->flash('error', "Existem $qtdOcorrencias Ocorrências com essa especialidade!");
            return redirect()->back();
        }

        if($especialidade->trashed())
        {
            $especialidade->forceDelete();
            session()->flash('success', 'Especialidade removida com sucesso!');
        }
        else
        {
            $especialidade->delete();
            session()->flash('success', 'Especialidade movida para lixeira com sucesso!');
        }
        return redirect()->back();
    }

    public function trashed()
    {
        $especialidades = Especialidade::selectRaw('especialidades.*')->onlyTrashed()->orderBy('name')->get();
        return view('especialidades.index', ['especialidades' => $especialidades]);
    }

    public function restore($id)
    {
        $especialidade = Especialidade::withTrashed()->where('id', $id)->firstOrFail();
        $especialidade->restore();
        session()->flash('success', 'Especialidade ativada com sucesso!');
        return redirect()->back();
    }

    public function buscarTrashed(Request $request)
    {
        $codigo = $request->input('codigo');
        $nome   = $request->input('nome');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres ou joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo campos e joins e wheres da select que são fixas
        $especialidades = Especialidade::selectRaw('especialidades.*')->onlyTrashed();

        // Definindo Wheres
            // Código
            if ( !empty($codigo) )
            {
                $especialidades = $especialidades->where('especialidades.id', 'LIKE', '%' . $codigo . '%');
            }

            // Nome
            if ( !empty($nome) )
            {
                $especialidades = $especialidades->where('especialidades.name', 'LIKE', '%' . $nome . '%');
            }

        // Definindo ordem
        $especialidades = $especialidades->orderBy('name');

        // Após definir todos os joins, where etc, executa a select
        $especialidades = $especialidades->get();

        // Retornar View com registros e buscas aplicadas
        return view('especialidades.index')
        ->with('especialidades', $especialidades )
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
        $especialidades = Especialidade::selectRaw('especialidades.*');

        // Definindo Wheres
            // Código
            if ( !empty($codigo) )
            {
                $especialidades = $especialidades->where('especialidades.id', 'LIKE', '%' . $codigo . '%');
            }

            // Nome
            if ( !empty($nome) )
            {
                $especialidades = $especialidades->where('especialidades.name', 'LIKE', '%' . $nome . '%');
            }

        // Definindo ordem
        $especialidades = $especialidades->orderBy('name');

        // Após definir todos os joins, where etc, executa a select
        $especialidades = $especialidades->get();

        // Retornar View com registros e buscas aplicadas
        return view('especialidades.index')
        ->with('especialidades', $especialidades )
        ->with('codigo_Buscado',$codigo)
        ->with( ['nome_Buscado' => $nome] );
    }

}
