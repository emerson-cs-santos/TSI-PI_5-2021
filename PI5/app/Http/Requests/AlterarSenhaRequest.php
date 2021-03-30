<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlterarSenhaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'password'                 => 'required_with:password_confirmation|same:password_confirmation|min:8'
            ,'password_confirmation'    => 'min:8'
        ];
    }
}
