<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\EditPerfilRequest;
use App\Http\Requests\AlterarSenhaRequest;
use App\Models\User;
use App\Models\Caso;
use App\Models\Ocorrencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Boolean;

class PerfilController extends Controller
{
    public function perfil()
    {
        return view('perfil');
    }

    public function updatePerfil(EditPerfilRequest $request)
    {
       // Proteção para não colocar data maior que a data atual
       $dataNovaSemFormatar = strtotime($request->nascimento);
       $dataNova = date('d-m-Y',$dataNovaSemFormatar);

       // Conversão strtotime não funciona de data estiver formatada com / (exemplo d/m/Y), apenas se estiver com - (d-m-Y)

      if (  strtotime($dataNova) > strtotime(date('d-m-Y')) )
      {
        $dataNova = date('d/m/Y',$dataNovaSemFormatar);
        session()->flash('error', "Data informada: $dataNova é maior que a data de hoje: " . date('d/m/Y'));
        return redirect()->back();
      }

        $usuario = User::find( Auth::user()->id );

       $usuario->name = $request->name;
       $usuario->email = $request->email;
       $usuario->genero = $request->genero;
       $usuario->nascimento = $request->nascimento;

        if($usuario->email != $request->email){
            $usuario->email = $request->email;
            $usuario->email_verified_at = null;
        }

        // Apenas gravar imagem se foi alterada
        $file = $request->file('imagem');
       if ( !empty($file) )
       {
            $data               = file_get_contents($file);
            $dataEncoded        = base64_encode($data);
            $imagem_convertida  = "data:image/jpeg;base64,$dataEncoded";

            $usuario->image     = $imagem_convertida;
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
        $details = [
            'title' => 'Email de Controle sua Saúde!',
            'body' => 'Perfil e dados do seu usuário foram excluídos conforme seu pedido.'
        ];

        $usuario = User::find( Auth::user()->id );

        \Mail::to( $usuario->email )->send(new \App\Mail\ExcluiuPerfilMail($details));

        $this->apagarPerfilBanco(0);

        session()->flash('success', 'Usuário apagado com sucesso, foi enviado um e-mail para você confirmando essa ação. É uma pena ver você ir, esperamos ter ajudado =D');

        // Fazer logout
        return redirect( route( 'index' ) );
    }

    public function apagarPerfilBanco(int $userID)
    {
        // Não será vazio quando chamado pelo test unit
        if ( empty($userID) )
        {
            $userID = Auth::user()->id;
        }

        // Apagar casos e Ocorrencias
        $casosApagar = Caso::withTrashed()
        ->where('user_id', $userID )
        ->get();

        foreach ($casosApagar as $casoApagar)
        {
            $ocorrenciasApagar = Ocorrencia::withTrashed()
            ->where('user_id', $userID )
            ->where('caso_id', $casoApagar->id )
            ->get();

            foreach ($ocorrenciasApagar as $ocorrenciaApagar)
            {
                // Apagar Ocorrencias dos Casos
                $ocorrenciaApagar->forceDelete();
            }

            // Apagar Casos do Usuário
            $casoApagar->forceDelete();
        }

        // Apagar usuário
       // $usuario = User::find( $userID );
        $usuario = User::withTrashed()->where('id', $userID)->first();
        $usuario->forceDelete();
    }
}
