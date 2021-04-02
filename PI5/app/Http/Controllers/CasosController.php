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
        $casos = Caso::selectRaw('casos.*')->where('user_id', '=', Auth::user()->id )->orderByDesc('id')->paginate(5);

        return view('casos.index', ['casos' => $casos] );
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

        return view('Casos.show')->with('caso', $caso);
    }


    public function edit( $id )
    {
        $caso = Caso::withTrashed()->where('id', $id)->firstOrFail();

        return view('Casos.edit')->with('caso', $caso);
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
        $casos = Caso::selectRaw('casos.*')->onlyTrashed()->where('user_id', '=', Auth::user()->id )->orderByDesc('id')->paginate(5);
        return view('Casos.index', ['casos' => $casos]);
    }

    public function restore($id)
    {
        $caso = Caso::withTrashed()->where('id', $id)->firstOrFail();
        $caso->restore();
        session()->flash('success', 'Caso ativado com sucesso!');
        return redirect()->back();
    }

    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $casos = Caso::selectRaw('casos.*')
            ->where('user_id', '=', Auth::user()->id )
            ->where ( 'casos.nome', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'casos.id', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'casos.status', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('nome')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $casos->appends ( array ('busca' => $request->input('busca')  ) );

            return view('Casos.index')
            ->with('casos',$casos )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $casos = Caso::selectRaw('casos.*')
            ->where('user_id', '=', Auth::user()->id )
            ->orderBy('nome')
            ->paginate(5)
            ->setPath ( '' );

            return view('Casos.index')
            ->with('casos', $casos )
            ->with('busca','');
        }
    }
}
