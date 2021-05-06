<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LVR\Colour\Hex; // Validar CoR

class CreateTiposRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:tipos'
            ,'color' => ['required', new Hex]
        ];
    }
}
