<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idea_empresa_id',
        'empresa_id',
        'titulo',
        'descripcion',
        'documento',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'respuestas';

    public function ideaEmpresa()
    {
        return $this->belongsTo(IdeaEmpresa::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
