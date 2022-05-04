<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoFormacion extends Model
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
        'foto',
        'descripcion',
        'nombre_responsable',
        'correo_responsable',
        'celular_responsable'
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'equipos_formacion';

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    public function disciplinasSubareaConocimiento()
    {
        return $this->belongsToMany(DisciplinaSubareaConocimiento::class, 'equipo_disciplina_subarea_conocimiento', 'equipo_formacion_id', 'disciplina_subarea_conocimiento_id');
    }

    public function scopeSearchEquiposFormacion($query, $keyword)
    {
        $keyword = mb_strtolower($keyword);

        return $query->select('equipos_formacion.*')
            ->distinct('equipos_formacion.id')
            ->join('equipo_disciplina_subarea_conocimiento', 'equipos_formacion.id', 'equipo_disciplina_subarea_conocimiento.equipo_formacion_id')
            ->join('disciplinas_subarea_conocimiento', 'equipo_disciplina_subarea_conocimiento.disciplina_subarea_conocimiento_id', 'disciplinas_subarea_conocimiento.id')
            ->join('subareas_conocimiento', 'disciplinas_subarea_conocimiento.subarea_conocimiento_id', 'subareas_conocimiento.id')
            ->join('areas_conocimiento', 'subareas_conocimiento.area_conocimiento_id', 'areas_conocimiento.id')
            ->whereRaw('lower(equipos_formacion.nombre) LIKE (?)', "%$keyword%")
            ->orWhereRaw('lower(areas_conocimiento.nombre) LIKE (?)', "%$keyword%")
            ->orWhereRaw('lower(disciplinas_subarea_conocimiento.nombre) LIKE (?)', "%$keyword%");
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterEquipoFormacion($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('equipos_formacion.nombre', 'like', '%' . $search . '%');
        });
    }
}
