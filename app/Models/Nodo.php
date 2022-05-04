<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Nodo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'administrador_id',
        'departamento',
        'logo'
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'nodos';

    public function institucionesEducativas()
    {
        return $this->hasMany(InstitucionEducativa::class);
    }

    public function eventosRredsiDepartamental()
    {
        return $this->hasMany(EventoRredsiDepartamental::class);
    }

    public function administrador()
    {
        return $this->belongsTo(User::class, 'administrador_id');
    }

    /**
     * Shuffle 4 proyectos for Welcome view.
     *
     * @return $proyectos
     */
    public function shuffleProyectos()
    {
        $proyectos = collect([]);
        foreach ($this->institucionesEducativas as $institucionEducativa) {
            foreach ($institucionEducativa->facultades as $facultad) {
                foreach ($facultad->proyectos as $proyecto) {
                    $proyectos->add($proyecto);
                }
            }
        }

        return $proyectos->where('privado', 0)->take(3)->shuffle();
    }

    /**
     * Shuffle 2 eventos de institución educativa.
     *
     * @return $eventos
     */

    public function shuffleEventosInstitucionesEducativas($disciplinaSubareaConocimiento = null)
    {
        $eventos = collect([]);
        $disciplinaSubareaConocimiento = mb_strtolower($disciplinaSubareaConocimiento);

        foreach ($this->institucionesEducativas as $institucionEducativa) {
            foreach ($institucionEducativa->eventos as $evento) {
                if ($evento->fecha_inicio > date('Y-m-d')) {
                    $eventos->add($evento);
                }
            }
        }

        if ($disciplinaSubareaConocimiento) {
            return $eventos->map(function ($evento) use ($disciplinaSubareaConocimiento) {
                return $evento->whereHas('disciplinasSubareaConocimiento', function ($query) use ($disciplinaSubareaConocimiento) {
                    return $query->whereRaw('lower(disciplinas_subarea_conocimiento.nombre) LIKE (?)', "%$disciplinaSubareaConocimiento%");
                })->get();
            })->unique()->flatten();
        }

        return $eventos;
    }

    /**
     * Get qty proyectos by ciudad for Welcome view.
     *
     * @return $qty
     */
    public function qtyProyectosByCiudad()
    {
        return DB::table('proyectos')->select(DB::raw('instituciones_educativas.ciudad, count(instituciones_educativas.ciudad) as count'))->join('proyecto_semillero_investigacion', 'proyectos.id', 'proyecto_semillero_investigacion.proyecto_id')->join('semilleros_investigacion', 'proyecto_semillero_investigacion.semillero_investigacion_id', 'semilleros_investigacion.id')->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->join('instituciones_educativas', 'facultades.institucion_educativa_id', 'instituciones_educativas.id')->groupBy(DB::raw('instituciones_educativas.ciudad'))->get();
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterNodo($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
