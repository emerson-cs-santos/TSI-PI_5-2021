<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LVR\Colour\Hex; // Validar CoR

class EditTiposRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required'
            ,'color' => ['required', new Hex]
        ];
    }
}
