<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditOcorrenciasRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'especialidade_id' => 'required'
            ,'tipo'             => 'required'
            ,'data'             => 'required'
            ,'importancia'      => 'required'
            ,'resumo'           => 'required|min:10'
        ];
    }
}
