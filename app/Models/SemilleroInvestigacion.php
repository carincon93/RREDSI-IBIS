<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemilleroInvestigacion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grupo_investigacion_id',
        'estudiante_lider_id',
        'nombre',
        'nombre_mentor',
        'correo_mentor',
        'celular_mentor',
        'objetivo_general',
        'mision',
        'vision',
        'proyeccion_regional',
        'estrategia_produccion_conocimiento',
        'tematica_investigacion',
        'fecha_creacion'
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'semilleros_investigacion';

    public function grupoInvestigacion()
    {
        return $this->belongsTo(GrupoInvestigacion::class);
    }

    public function estudianteLider()
    {
        return $this->belongsTo(User::class);
    }

    public function programasAcademicos()
    {
        return $this->belongsToMany(ProgramaAcademico::class, 'semillero_programa_academico', 'semillero_investigacion_id', 'programa_academico_id');
    }

    public function lineasInvestigacion()
    {
        return $this->belongsToMany(LineaInvestigacion::class, 'semillero_linea_investigacion', 'semillero_investigacion_id', 'linea_investigacion_id');
    }

    public function disciplinasSubareaConocimiento()
    {
        return $this->belongsToMany(DisciplinaSubareaConocimiento::class, 'semillero_disciplina_subarea_conocimiento', 'semillero_investigacion_id', 'disciplina_subarea_conocimiento_id');
    }

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_semillero_investigacion', 'semillero_investigacion_id', 'proyecto_id');
    }

    public function proyectosEventoRredsiDepartamental()
    {
        return $this->hasMany(ProyectoEventoRredsiDepartamental::class);
    }

    public function miembros()
    {
        return $this->belongsToMany(User::class, 'semillero_user')
            ->withPivot([
                'comentario',
                'aceptado_en',
                'retirado_en',
                'externo',
                'carta_autorizacion',
            ]);
    }


    public static function filterProyectos()
    {
        $authUser = auth()->user();

        if ($authUser->proyectos() && $authUser->hasRole(4)) {
            return $authUser->proyectos();
        }

        $_this = new self;
        return $_this->first()->proyectos();
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterSemilleroInvestigacion($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
