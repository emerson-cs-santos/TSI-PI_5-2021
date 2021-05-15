<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Caso;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $user = User::selectRaw('users.*')->get();
        $userCount = $user->count();

        $caso = Caso::selectRaw('casos.*')->where('status', '=', 'Curado')->get();
        $casoCount = $caso->count();

        $premium = User::selectRaw('users.*')->where('premium', '=', 'Sim')->get();
        $premiumCount = $premium->count();

        return view('index')->with('userCount',$userCount)->with('casoCount',$casoCount)->with('premiumCount',$premiumCount);
    }

    public function termos()
    {
        return view('termos');
    }

    public function sobre()
    {
        return view('sobre');
    }

    public function ajuda()
    {
        return view('ajuda');
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
