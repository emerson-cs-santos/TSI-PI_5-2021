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

        return view('usuarios', ['usuarios' => $users])
        ->with('nivel_Buscado','todos')
        ->with('premium_Buscado','todos');
    }

    public function indexBanco()
    {
        $users = User::selectRaw('users.*')->orderBy('name')->get();

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
        return view('usuarios', ['usuarios' => $users])
        ->with('nivel_Buscado','todos')
        ->with('premium_Buscado','todos');
    }

    public function trashedBanco()
    {
        $users = User::selectRaw('users.*')->onlyTrashed()->orderBy('name')->get();
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

    public function buscarTrashed(Request $request)
    {
        $codigo     = $request->input('codigo');
        $nome       = $request->input('nome');
        $nivel      = $request->input('nivel');
        $premium    = $request->input('premium');
        $email      = $request->input('email');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres oi joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo campos e joins
        $users = User::selectRaw('users.*')->onlyTrashed();

        // Definindo Wheres
            // Código
            if ( !empty($codigo) )
            {
                $users = $users->where('users.id', $codigo);
            }

            // Nome
            if ( !empty($nome) )
            {
                $users = $users->where('users.name', 'LIKE', '%' . $nome . '%');
            }

            // Nível
            if ( !empty($nivel) and $nivel !== 'todos' )
            {
                $nivelInterno = '';

                if ( $nivel == 'adm' )
                {
                    $nivelInterno = 'admin';
                }
                else
                {
                    $nivelInterno = 'default';
                }

                $users = $users->where('users.type', $nivelInterno);
            }

            // Premium
            if ( !empty($premium) and $premium !== 'todos' )
            {
                $users = $users->where('users.premium', $premium == 'Sim' ? 'sim' : 'nao');
            }

            // Email
            if ( !empty($email) )
            {
                $users = $users->where('users.name', 'LIKE', '%' . $email . '%');
            }

        // Definindo ordem
        $users = $users->orderBy('name');

        // Após definir todos os joins, where etc, executa a select
        $users = $users->get();

        // Retornar View com registros e buscas aplicadas
        return view('usuarios')
        ->with('usuarios', $users )
        ->with('codigo_Buscado',$codigo)
        ->with('nome_Buscado',$nome)
        ->with('nivel_Buscado',$nivel)
        ->with('premium_Buscado',$premium )
        ->with('email_Buscado',$email);
    }

    public function buscar(Request $request)
    {
        $codigo     = $request->input('codigo');
        $nome       = $request->input('nome');
        $nivel      = $request->input('nivel');
        $premium    = $request->input('premium');
        $email      = $request->input('email');

        // É possivel adicionar metodos em linhas diferentes (where, join, etc), contanto que seja na ordem correta (select, joins, where, order by)
        // Ao adicionar wheres ou joins é possivel adicionar apenas o que precisar, fazendo como as wheres abaixo.

        // Definindo campos e joins
        $users = User::selectRaw('users.*');

        // Definindo Wheres
            // Código
            if ( !empty($codigo) )
            {
                $users = $users->where('users.id', $codigo);
            }

            // Nome
            if ( !empty($nome) )
            {
                $users = $users->where('users.name', 'LIKE', '%' . $nome . '%');
            }

            // Nível
            if ( !empty($nivel) and $nivel !== 'todos' )
            {
                $nivelInterno = '';

                if ( $nivel == 'adm' )
                {
                    $nivelInterno = 'admin';
                }
                else
                {
                    $nivelInterno = 'default';
                }

                $users = $users->where('users.type', $nivelInterno);
            }

            // Premium
            if ( !empty($premium) and $premium !== 'todos' )
            {

                $users = $users->where('users.premium', $premium == 'Sim' ? 'sim' : 'nao');
            }

            // Email
            if ( !empty($email) )
            {
                $users = $users->where('users.name', 'LIKE', '%' . $email . '%');
            }

        // Definindo ordem
        $users = $users->orderBy('name');

        // Após definir todos os joins, where etc, executa a select
        $users = $users->get();

        // Retornar View com registros e buscas aplicadas
        return view('usuarios')
        ->with('usuarios', $users )
        ->with('codigo_Buscado',$codigo)
        ->with('nome_Buscado',$nome)
        ->with('nivel_Buscado',$nivel)
        ->with('premium_Buscado',$premium )
        ->with('email_Buscado',$email);
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
