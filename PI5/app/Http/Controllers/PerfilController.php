<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\EditPerfilRequest;
use App\Http\Requests\AlterarSenhaRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function perfil()
    {
        return view('perfil');
    }

    public function updatePerfil(EditPerfilRequest $request)
    {
       $usuario = User::find( Auth::user()->id );

       $usuario->name = $request->name;
       $usuario->email = $request->email;
       $usuario->genero = $request->genero;
       $usuario->nascimento = $request->nascimento;

        if($usuario->email != $request->email){
            $usuario->email = $request->email;
            $usuario->email_verified_at = null;
        }

       $usuario->save();

        session()->flash('success', 'Informações atualizadas com sucesso!');

        return redirect(route('perfil'));
    }


    public function updatePerfilSenha(AlterarSenhaRequest $request)
    {
       $usuario = User::find( Auth::user()->id );

       if ( !Hash::check($request->SenhaAtual, $usuario->password)  )
       {
            session()->flash('error', "Senha atual não confere!");
            return redirect()->back();
       }

        $usuario->password = Hash::make( $request['password'] );

        $usuario->save();

        session()->flash('success', 'Senha alterada com sucesso!');

        return redirect(route('perfil'));
    }

    public function apagarPerfil()
    {
        // Perguntar antes com sweetalert

        // Apagar Ocorrencias

        // Apagar casos

        // apagar usuário

        // Fazer logout
    }
}
