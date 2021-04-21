<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class arquivo extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id'
        ,'caso_id'
        ,'ocorrencia_id'
        ,'nome'
        ,'extensao'
    ];
}
