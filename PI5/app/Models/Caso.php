<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caso extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable =['nome','status', 'user_id', 'desc', 'medicamentos'];

    public function ocorrencias()
    {
        Return $this->hasMany(Ocorrencia::class, 'caso_id');
    }
}
