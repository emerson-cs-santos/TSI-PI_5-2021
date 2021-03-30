<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function perfil()
    {
        return view('perfil');
    }

    public function teste()
    {
        session()->flash('success', 'Informações atualizadas com sucesso!');

        return redirect(route('perfil'));
    }
}
