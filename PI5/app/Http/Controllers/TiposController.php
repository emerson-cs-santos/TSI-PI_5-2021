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
        $Tipos = Tipo::selectRaw('tipos.*')->orderByDesc('id')->paginate(5);
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

        return view('Tipos.show')->with('tipo', $tipo);
    }

    public function edit($id)
    {
        $tipo = Tipo::withTrashed()->where('id', $id)->firstOrFail();

        return view('Tipos.edit')->with('tipo', $tipo);
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
        $tipos = Tipo::selectRaw('tipos.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return view('tipos.index', ['tipos' => $tipos]);
    }

    public function restore($id)
    {
        $especialidade = Tipo::withTrashed()->where('id', $id)->firstOrFail();
        $especialidade->restore();
        session()->flash('success', 'Tipo ativado com sucesso!');
        return redirect()->back();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $tipos = Tipo::selectRaw('tipos.*')
            ->where ( 'tipos.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'tipos.id', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $tipos->appends ( array ('busca' => $request->input('busca')  ) );

            return view('tipos.index')
            ->with('tipos',$tipos )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $tipos = Tipo::selectRaw('tipos.*')
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            return view('tipos.index')
            ->with('tipos', $tipos )
            ->with('busca','');
        }
    }

}
