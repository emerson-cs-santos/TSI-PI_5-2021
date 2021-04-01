<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCasosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome'      => 'required|min:5'
            ,'status'   => 'required'
        ];
    }
}
