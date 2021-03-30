<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\UserEmail;

class EditPerfilRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'    => 'required|min:3'
            ,'email'  => [ 'required', 'email:filter', new UserEmail( request()->all() ) ]
        ];
    }
}
