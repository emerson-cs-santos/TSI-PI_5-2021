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

         Auth::login( $user );

         return redirect( route( 'index' ) );
    }
}
