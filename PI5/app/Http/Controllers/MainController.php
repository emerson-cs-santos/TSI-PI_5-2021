<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function premium()
    {
        return view('premium');
    }

    public function premiumMudar()
    {
        $usuario = User::find( Auth::user()->id );

        if( $usuario->premium == 'sim' )
        {
            session()->flash('success', 'Que pena! Agora você NÂO tem acesso a todos os recursos do site!');
            $usuario->premium = 'nao';
        }
        else
        {
            session()->flash('success', 'Parabens! Agora você tem acesso a todos os recursos do site!');
            $usuario->premium = 'sim';
        }

        $usuario->save();

        return redirect(route('premium'));
    }
}
