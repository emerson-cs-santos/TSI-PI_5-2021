<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caso;
use App\Http\Requests\CreateCasosRequest;
use App\Http\Requests\EditCasosRequest;
use Illuminate\Support\Facades\Auth;

class CasosController extends Controller
{
    public function index()
    {
        $casos = Caso::selectRaw('casos.*')->where('user_id', '=', Auth::user()->id )->orderByDesc('id')->paginate(5);

        return view('casos.index', ['casos' => $casos]);
    }

    public function create()
    {
        return view('casos.create');
    }


    public function store(CreateCasosRequest $request)
    {
        Caso::create([
            'user_id'       => Auth::user()->id
            ,'nome'         => $request->name
            ,'desc'         => $request->desc
            ,'status'       => $request->status
            ,'medicamentos' => $request->medicamentos
        ]);

       session()->flash('success', 'Caso criado com sucesso!');

        return redirect(route('Casos.index'));
    }


    public function show( $id )
    {
        $especialidade = Caso::withTrashed()->where('id', $id)->firstOrFail();

        return view('Especialidades.show')->with('especialidade', $especialidade);
    }


    public function edit( $id )
    {
        $especialidade = Caso::withTrashed()->where('id', $id)->firstOrFail();

        return view('Especialidades.edit')->with('especialidade', $especialidade);
    }


    public function update( EditCasosRequest $request, $id )
    {
        $especialidade = Caso::withTrashed()->where('id', $id)->firstOrFail();

        $especialidade->update([
            'name'  => $request->name
        ]);

        session()->flash('success', 'Caso alterado com sucesso!');
        return redirect(route('Especialidades.index'));
    }


    public function destroy($id)
    {
        $especialidade = Caso::withTrashed()->where('id', $id)->firstOrFail();

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
        $especialidades = Caso::selectRaw('especialidades.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return view('especialidades.index', ['especialidades' => $especialidades]);
    }

    public function restore($id)
    {
        $especialidade = Caso::withTrashed()->where('id', $id)->firstOrFail();
        $especialidade->restore();
        session()->flash('success', 'Especialidade ativada com sucesso!');
        return redirect()->back();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $especialidades = Caso::selectRaw('especialidades.*')
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
            $especialidades = Caso::selectRaw('especialidades.*')
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            return view('especialidades.index')
            ->with('especialidades', $especialidades )
            ->with('busca','');
        }
    }
}
