<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbienteFormacion extends Model
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
        'nombre_responsable',
        'correo_responsable',
        'celular_responsable',
        'tpo',
        'capacidad_aprox',
        'descripcion',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'ambientes_formacion';

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    public function disciplinasSubareaConocimiento()
    {
        return $this->belongsToMany(DisciplinaSubareaConocimiento::class, 'ambiente_disciplina_subarea_conocimiento', 'ambiente_formacion_id', 'disciplina_subarea_conocimiento_id');
    }

    public function scopeSearchAmbientesFormacion($query, $keyword)
    {
        $keyword = mb_strtolower($keyword);

        return $query->select('ambientes_formacion.*')
            ->distinct('ambientes_formacion.id')
            ->join('ambiente_disciplina_subarea_conocimiento', 'ambientes_formacion.id', 'ambiente_disciplina_subarea_conocimiento.ambiente_formacion_id')
            ->join('disciplinas_subarea_conocimiento', 'ambiente_disciplina_subarea_conocimiento.disciplina_subarea_conocimiento_id', 'disciplinas_subarea_conocimiento.id')
            ->join('subareas_conocimiento', 'disciplinas_subarea_conocimiento.subarea_conocimiento_id', 'subareas_conocimiento.id')
            ->join('areas_conocimiento', 'subareas_conocimiento.area_conocimiento_id', 'areas_conocimiento.id')
            ->whereRaw('lower(ambientes_formacion.nombre) LIKE (?)', "%$keyword%")
            ->orWhereRaw('lower(ambientes_formacion.tipo) LIKE (?)', "%$keyword%")
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
    public function scopeFilterAmbienteFormacion($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('ambientes_formacion.nombre', 'like', '%' . $search . '%');
        });
    }
}
