<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineaInvestigacion extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'area_conocimiento_id',
        'grupo_investigacion_id',
        'nombre',
        'objetivos',
        'mision',
        'vision',
        'logros',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'lineas_investigacion';

    public function areaConocimiento()
    {
        return $this->belongsTo(AreaConocimiento::class);
    }

    public function grupoInvestigacion()
    {
        return $this->belongsTo(GrupoInvestigacion::class);
    }

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_linea_investigacion', 'linea_investigacion_id', 'proyecto_id');
    }

    public function semillerosInvestigacion()
    {
        return $this->belongsToMany(SemilleroInvestigacion::class, 'semillero_linea_investigacion', 'linea_investigacion_id', 'semillero_investigacion_id');
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterLineaInvestigacion($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
