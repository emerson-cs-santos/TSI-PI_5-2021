<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::selectRaw('users.*')->orderByDesc('id')->paginate(5);

        return view('usuarios', ['usuarios' => $users]);
    }

    public function destroy($id)
    {
        if ( auth()->user()->id  == intval($id) )
        {
            session()->flash('error', "Você não pode excluir seu próprio usuário!");
            return redirect()->back();
        }

        $User = User::withTrashed()->where('id', $id)->firstOrFail();

        if($User->trashed())
        {
            $User->forceDelete();
            session()->flash('success', 'Usuário apagado com sucesso!');
        }
        else
        {
            $User->delete();
            session()->flash('success', 'Usuário movido para lixeira com sucesso!');
        }

        return redirect()->back();
    }


    public function trashed()
    {
        $users = User::selectRaw('users.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return view('admin.usuario.index', ['usuarios' => $users]);
    }


    public function restore($id)
    {
        $user = User::withTrashed()->where('id', $id)->firstOrFail();
        $user->restore();
        session()->flash('success', 'Usuário ativado com sucesso!');
        return redirect()->back();
    }


    public function buscar(Request $request)
    {
        $buscar = $request->input('busca');

        if($buscar != "")
        {
            $users = User::selectRaw('users.*')
            ->where ( 'users.name', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.id', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.email', 'LIKE', '%' . $buscar . '%' )
            ->orWhere ( 'users.type', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $users->appends ( array ('busca' => $request->input('busca')  ) );

            return view('admin.usuario.index')
            ->with('usuarios',$users )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $users = User::selectRaw('users.*')
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            return view('admin.usuario.index')
            ->with('usuarios', $users )
            ->with('busca','');
        }
    }
}
