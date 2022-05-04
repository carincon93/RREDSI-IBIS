<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Evento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'ubicacion',
        'descripcion',
        'fecha_inicio',
        'fecha_finalizacion',
        'link_registro',
        'info_link',
        'objetivos',
        'cronograma',
        'imagen_principal',
        'afiche',
        'institucion_educativa_id'
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'eventos';

    /**
     * appends
     *
     * @var array
     */
    protected $appends = ['datesForHumans'];

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'evento_proyecto', 'evento_id', 'proyecto_id');
    }

    public function institucionEducativa()
    {
        return $this->belongsTo(InstitucionEducativa::class);
    }

    public function disciplinasSubareaConocimiento()
    {
        return $this->belongsToMany(DisciplinaSubareaConocimiento::class, 'evento_disciplina_subarea_conocimiento', 'evento_id', 'disciplina_subarea_conocimiento_id');
    }

    public function getDatesForHumansAttribute()
    {
        $fechaInicio = Carbon::parse($this->fecha_inicio, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        $fechaFinalizacion   = Carbon::parse($this->fecha_finalizacion, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        return "Del $fechaInicio al $fechaFinalizacion";
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterEvento($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
