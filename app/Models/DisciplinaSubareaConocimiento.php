<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaSubareaConocimiento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subarea_conocimiento_id',
        'nombre'
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'disciplinas_subarea_conocimiento';

    public function proyectos()
    {
        return $this->belongsToMany(Proyecto::class, 'proyecto_disciplina_subarea_conocimiento', 'disciplina_subarea_conocimiento_id', 'proyecto_id');
    }

    public function semillerosInvestigacion()
    {
        return $this->belongsToMany(SemilleroInvestigacion::class, 'semillero_disciplina_subarea_conocimiento', 'disciplina_subarea_conocimiento_id', 'semillero_investigacion_id');
    }

    public function equiposFormacion()
    {
        return $this->belongsToMany(EquipoFormacion::class, 'equipo_disciplina_subarea_conocimiento', 'disciplina_subarea_conocimiento_id', 'equipo_formacion_id');
    }

    public function ambientesFormacion()
    {
        return $this->belongsToMany(AmbienteFormacion::class, 'ambiente_disciplina_subarea_conocimiento', 'disciplina_subarea_conocimiento_id', 'ambiente_formacion_id');
    }

    public function subareaConocimiento()
    {
        return $this->belongsTo(SubareaConocimiento::class);
    }

    public function trabajosGrado()
    {
        return $this->hasMany(TrabajoGrado::class);
    }
}
