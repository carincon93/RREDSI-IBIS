<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProgramaAcademico extends Model
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
        'nivel_academico',
        'modalidad',
        'jornada',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'programas_academicos';

    protected $appends = ['datesForHumans'];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    public function semillerosInvestigacion()
    {
        return $this->belongsToMany(SemilleroInvestigacion::class, 'semillero_programa_academico', 'programa_academico_id', 'semillero_investigacion_id');
    }

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_programa_academico', 'programa_academico_id', 'proyecto_id');
    }

    public function primerPonente()
    {
        return $this->hasOne(ProyectoEventoRredsiDepartamental::class, 'programa_academico_primer_ponente_id');
    }

    public function segundoPonente()
    {
        return $this->hasOne(ProyectoEventoRredsiDepartamental::class, 'programa_academico_segundo_ponente_id');
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
    public function scopeFilterProgramaAcademico($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('programas_academicos.nombre', 'like', '%' . $search . '%');
        });
    }
}
