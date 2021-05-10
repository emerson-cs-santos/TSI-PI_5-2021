<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RedeSocialLoginController extends Controller
{
    public function redirectToProvider( $provider )
    {
        return Socialite::driver( $provider )->redirect();
    }

    public function handleProviderCallback( $provider )
    {
        // stateless não tem quando é twitter
        if ( $provider == 'twitter' )
        {
            $userProvider = Socialite::driver( $provider )->user();
        }
        else
        {
            $userProvider = Socialite::driver( $provider )->stateless()->user();
        }

         $user = User::firstOrCreate(
              [ 'email' => $userProvider->getEmail() ],
              [ 'name' => $userProvider->getName() ?? $userProvider->getNickname()
             , 'password' => 'loginSocialite' ]

         );

        // Tenta obter imagem de perfil
        try
        {
            if ( empty($user->image) ) // Apenas grava imagem da rede social se já não houver imagem salva no perfil
            {
                $imagem = $userProvider->getAvatar();

                $data               = file_get_contents($imagem);
                $dataEncoded        = base64_encode($data);
                $imagem_convertida  = "data:image/jpeg;base64,$dataEncoded";

                if ( !empty($imagem_convertida) )
                {
                    $user->image = $imagem_convertida;
                    $user->save();
                }
            }
        }

        catch (\Throwable $th)
        {
            session()->flash('error', "Desculpe, mas não possivel obter a sua imagem de perfil.");
        }

         Auth::login( $user );

         return redirect( route( 'index' ) );
    }
}
