<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\PerfilController;

class UsersController extends Controller
{
    public function index()
    {
        $users = $this->indexBanco();

        return view('usuarios', ['usuarios' => $users]);
    }

    public function indexBanco()
    {
        $users = User::selectRaw('users.*')->orderByDesc('id')->paginate(5);

        return $users;
    }

    public function destroy($id)
    {
        if ( auth()->user()->id  == intval($id) )
        {
            session()->flash('error', "Você não pode excluir seu próprio usuário!");
            return redirect()->back();
        }

        $this->destroyBanco($id);

        return redirect()->back();
    }

    public function destroyBanco($id)
    {
        $User = User::withTrashed()->where('id', $id)->firstOrFail();

        if($User->trashed())
        {
           // $User->forceDelete();
            $perfilController = new PerfilController();
            $perfilController->apagarPerfilBanco( $id  );

            session()->flash('success', 'Usuário apagado com sucesso!');
        }
        else
        {
            $User->delete();
            session()->flash('success', 'Usuário movido para lixeira com sucesso!');
        }
    }


    public function trashed()
    {
        $users = $this->trashedBanco();
        return view('usuarios', ['usuarios' => $users]);
    }

    public function trashedBanco()
    {
        $users = User::selectRaw('users.*')->onlyTrashed()->orderByDesc('id')->paginate(5);
        return $users;
    }

    public function restore($id)
    {
        $this->restoreBanco($id);
        session()->flash('success', 'Usuário ativado com sucesso!');
        return redirect()->back();
    }

    public function restoreBanco($id)
    {
        $user = User::withTrashed()->where('id', $id)->firstOrFail();
        $user->restore();
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
            ->orWhere ( 'users.premium', 'LIKE', '%' . $buscar . '%' )
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            $pagination = $users->appends ( array ('busca' => $request->input('busca')  ) );

            return view('usuarios')
            ->with('usuarios',$users )->withQuery ( $buscar )
            ->with('busca',$buscar);
        }
        else
        {
            $users = User::selectRaw('users.*')
            ->orderBy('name')
            ->paginate(5)
            ->setPath ( '' );

            return view('usuarios')
            ->with('usuarios', $users )
            ->with('busca','');
        }
    }

    // Mudar nível de acesso
    public function typeUpdate($id)
    {
        $user = User::withTrashed()->where('id', $id)->firstOrFail();

        $nivel = 'Nível de acesso do ' . $user->name . ' alterado com sucesso para ';
        $nivelAcessoExibicao = '';

        if ( $user->type == 'default' )
        {
            $user->type = 'admin';
            $nivelAcessoExibicao = 'Administrador';
        }
        else
        {
            $user->type = 'default';
            $nivelAcessoExibicao = 'Padrão';
        }

        $user->save();

        $nivel = $nivel . $nivelAcessoExibicao . '!';
        session()->flash('success',  $nivel);
        return redirect()->back();
    }
}
