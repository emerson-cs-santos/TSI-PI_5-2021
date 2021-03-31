<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidade;
use App\Http\Requests\CreateEspecialidadesRequest;
use App\Http\Requests\EditEspecialidadesRequest;

class EspecialidadesController extends Controller
{

    public function index()
    {
        $especialidades = Especialidade::selectRaw('especialidades.*')->orderByDesc('id')->paginate(5);

        return view('especialidades.index', ['especialidades' => $especialidades]);
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

        return view('Especialidades.show')->with('especialidade', $especialidade);
    }


    public function edit( $id )
    {
        $especialidade = Especialidade::withTrashed()->where('id', $id)->firstOrFail();

        return view('Especialidades.edit')->with('especialidade', $especialidade);
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

        // $qtdProdutos = $category->products()->count();

        // if( $qtdProdutos > 0 )
        // {
        //     session()->flash('error', "Existem $qtdProdutos produtos com essa categoria!");
        //     return redirect()->back();
        // }

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
        $especialidades = Especialidade::selectRaw('especialidades.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return view('especialidades.index', ['especialidades' => $especialidades]);
    }

    public function restore($id)
    {
        $especialidade = Especialidade::withTrashed()->where('id', $id)->firstOrFail();
        $especialidade->restore();
        session()->flash('success', 'Especialidade ativada com sucesso!');
        return redirect()->back();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $especialidades = Especialidade::selectRaw('especialidades.*')
            ->where ( 'especialidades.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'especialidades.id', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $especialidades->appends ( array ('busca' => $request->input('busca')  ) );

            return view('especialidades.index')
            ->with('especialidades',$especialidades )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $especialidades = Especialidade::selectRaw('especialidades.*')
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            return view('especialidades.index')
            ->with('especialidades', $especialidades )
            ->with('busca','');
        }
    }
}
