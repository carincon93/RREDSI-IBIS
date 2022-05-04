<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoInvestigacion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facultad_id',
        'nombre',
        'email',
        'lider',
        'gruplac',
        'codigo_minciencias',
        'categoria_minciencias',
        'sitio_web',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'grupos_investigacion';

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    public function semillerosInvestigacion()
    {
        return $this->hasMany(SemilleroInvestigacion::class);
    }

    public function lineasInvestigacion()
    {
        return $this->hasMany(LineaInvestigacion::class);
    }

    public function trabajosGrado()
    {
        return $this->hasMany(TrabajoGrado::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterGrupoInvestigacion($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
