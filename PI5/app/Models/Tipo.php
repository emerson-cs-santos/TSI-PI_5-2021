<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable =['name', 'color'];

    public function ocorrencias()
    {
        Return $this->hasMany(Ocorrencia::class, 'tipo_id');
    }

    public function casos( int $tipoID ): int
    {
        $casos = Ocorrencia::selectRaw('casos.id')
        ->join('tipos', 'tipos.id', 'ocorrencias.tipo_id')
        ->join('casos', 'casos.id', 'ocorrencias.caso_id')
        ->where('tipos.id', $tipoID)
        ->groupBy('casos.id')
        ->orderByDesc('casos.id')
        ->get();

        return $casos->count();
    }
}
