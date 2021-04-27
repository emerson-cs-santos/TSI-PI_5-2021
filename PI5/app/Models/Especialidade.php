<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialidade extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $fillable =['name'];

    public function ocorrencias()
    {
        Return $this->hasMany(Ocorrencia::class, 'especialidade_id');
    }

    public function casos( int $especialidadeID ): int
    {
        $casos = Ocorrencia::selectRaw('casos.id')
        ->join('especialidades', 'especialidades.id', 'ocorrencias.especialidade_id')
        ->join('casos', 'casos.id', 'ocorrencias.caso_id')
        ->where('especialidades.id', $especialidadeID)
        ->groupBy('casos.id')
        ->orderByDesc('casos.id')
        ->get();

        return $casos->count();
    }
}
