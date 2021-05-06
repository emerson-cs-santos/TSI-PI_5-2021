<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ocorrencia extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
            'tipo_id'
            ,'data'
            ,'importancia'
            ,'especialidade_id'
            ,'resumo'
            ,'user_id'
            ,'caso_id'
            ,'medico'
            ,'crm'
            ,'receitas'
            ,'local'
            ,'desc'
            ,'arquivo'
        ];

    public function arquivos()
    {
        Return $this->hasMany(arquivo::class, 'ocorrencia_id');
    }
}
