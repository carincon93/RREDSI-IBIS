<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Proyecto extends Model
{
    protected $appends = ['datesForHumans', 'palabras_clave_format', 'requerimientos_equipos_format', 'requerimientos_roles_format'];

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'fecha_inicio',
        'fecha_finalizacion',
        'resumen',
        'palabras_clave',
        'file',
        'objetivo_general',
        'privado',
        'descripcion_requerimiento_rol',
        'requerimientos_roles',
        'requerimientos_equipos_descripcion',
        'requerimientos_equipos',
        'main_image',
        'tipo_proyecto_id',
        'facultad_id',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'proyectos';

    public function proyectosEventoRredsiDepartamental()
    {
        return $this->hasMany(ProyectoEventoRredsiDepartamental::class);
    }

    public function proyectosEmpresa()
    {
        return $this->hasMany(ProyectoEmpresa::class);
    }

    public function disciplinasSubareaConocimiento()
    {
        return $this->belongsToMany(DisciplinaSubareaConocimiento::class, 'proyecto_disciplina_subarea_conocimiento', 'proyecto_id', 'disciplina_subarea_conocimiento_id');
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_proyecto', 'proyecto_id', 'evento_id');
    }

    public function lineasInvestigacion()
    {
        return $this->belongsToMany(LineaInvestigacion::class, 'proyecto_linea_investigacion', 'proyecto_id', 'linea_investigacion_id');
    }

    public function semillerosInvestigacion()
    {
        return $this->belongsToMany(SemilleroInvestigacion::class, 'proyecto_semillero_investigacion', 'proyecto_id', 'semillero_investigacion_id');
    }

    public function programasAcademicos()
    {
        return $this->belongsToMany(ProgramaAcademico::class, 'proyecto_programa_academico', 'proyecto_id', 'programa_academico_id');
    }

    public function autores()
    {
        return $this->belongsToMany(User::class, 'autores', 'proyecto_id', 'user_id');
    }

    public function tipoProyecto()
    {
        return $this->belongsTo(TipoProyecto::class);
    }

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    public function getDatesForHumansAttribute()
    {
        $fechaInicio = Carbon::parse($this->fecha_inicio, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        $fechaFinalizacion   = Carbon::parse($this->fecha_finalizacion, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        return "$fechaInicio al $fechaFinalizacion";
    }

    public function scopeSearchProyectos($query, $tituloOrKeyword, $nodo)
    {
        $tituloOrKeyword = mb_strtolower($tituloOrKeyword);

        return $query->select('proyectos.*', 'tipos_proyecto.tipo')
            ->distinct('proyectos.id')
            ->join('facultades', 'proyectos.facultad_id', 'facultades.id')
            ->join('instituciones_educativas', 'facultades.institucion_educativa_id', 'instituciones_educativas.id')
            ->join('tipos_proyecto', 'proyectos.tipo_proyecto_id', 'tipos_proyecto.id')
            ->join('proyecto_disciplina_subarea_conocimiento', 'proyectos.id', 'proyecto_disciplina_subarea_conocimiento.proyecto_id')
            ->join('disciplinas_subarea_conocimiento', 'proyecto_disciplina_subarea_conocimiento.disciplina_subarea_conocimiento_id', 'disciplinas_subarea_conocimiento.id')
            ->join('subareas_conocimiento', 'disciplinas_subarea_conocimiento.subarea_conocimiento_id', 'subareas_conocimiento.id')
            ->join('areas_conocimiento', 'subareas_conocimiento.area_conocimiento_id', 'areas_conocimiento.id')
            ->whereRaw('lower(proyectos.titulo) LIKE (?)', "%$tituloOrKeyword%")
            ->where('proyectos.privado', 0)
            ->where('instituciones_educativas.nodo_id', $nodo->id)
            ->orWhereRaw('lower(areas_conocimiento.nombre) LIKE (?)', "%$tituloOrKeyword%")
            ->where('proyectos.privado', 0)
            ->where('instituciones_educativas.nodo_id', $nodo->id)
            ->orWhereRaw('lower(proyectos.palabras_clave) LIKE (?)', "%$tituloOrKeyword%")
            ->where('proyectos.privado', 0)
            ->where('instituciones_educativas.nodo_id', $nodo->id)
            ->orWhere('tipos_proyecto.tipo', $tituloOrKeyword)
            ->where('proyectos.privado', 0)
            ->where('instituciones_educativas.nodo_id', $nodo->id);
    }

    public function scopeAllKeywords($query, $nodo)
    {
        $allKeyWords = collect([]);

        foreach ($nodo->institucionesEducativas as $institucionEducativa) {
            foreach ($institucionEducativa->facultades as $facultad) {
                foreach ($facultad->proyectos as $proyecto) {
                    foreach (json_decode($proyecto->palabras_clave) as $palabras_clave) {
                        $allKeyWords->push(trim($palabras_clave->value));
                    }
                }
            }
        }

        return $allKeyWords->filter()->unique();
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterProyecto($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('titulo', 'like', '%' . $search . '%');
        });
    }

    /**
     * getPalabrasClaveFormatAttribute
     *
     * @return void
     */
    public function getPalabrasClaveFormatAttribute()
    {
        return json_decode($this->palabras_clave);
    }

    /**
     * getRequerimientosEquiposFormatFormatAttribute
     *
     * @return void
     */
    public function getRequerimientosEquiposFormatAttribute()
    {
        return json_decode($this->requerimientos_equipos);
    }

    /**
     * getPalabrasClaveFormatAttribute
     *
     * @return void
     */
    public function getRequerimientosRolesFormatAttribute()
    {
        return json_decode($this->requerimientos_roles);
    }
}
