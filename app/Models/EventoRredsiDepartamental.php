<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoRredsiDepartamental extends Model
{
    use HasFactory;

    /**
     * table
     *
     * @var string
     */
    protected $table = 'eventos_rredsi_departamental';

    /**
     * appends
     *
     * @var array
     */
    protected $appends = ['year', 'datesForHumans'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'nodo_id',
        'institucion_educativa_id',
        'fecha_inicio',
        'fecha_finalizacion',
        'afiche',
        'objetivos',
        'cronograma',
        'areas_conocimiento',
        'formato_guia_ponencia',
        'carta_aval_ponencia',
        'plantilla_presentacion_ponencia',
        'guia_proyecto_finalizado',
        'formato_guia_poster',
        'carta_aval_poster',
        'plantilla_presentacion_poster',
        'introduccion',
        'estado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Relationship with Nodo
     *
     * @return object
     */
    public function nodo()
    {
        return $this->belongsTo(Nodo::class);
    }

    /**
     * Relationship with InstitucionEducativa
     *
     * @return object
     */
    public function institucionEducativa()
    {
        return $this->belongsTo(InstitucionEducativa::class);
    }

    /**
     * Relationship with ProyectoEventoRredsiDepartamental
     *
     * @return object
     */
    public function proyectosEventoRredsiDepartamental()
    {
        return $this->hasMany(ProyectoEventoRredsiDepartamental::class);
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterEventoRredsiDepartamental($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('titulo', 'ilike', '%' . $search . '%');
        });
    }

    public function getYearAttribute()
    {
        return date('Y', strtotime($this->fecha_finalizacion));
    }

    public function getDatesForHumansAttribute()
    {
        $fechaInicio = Carbon::parse($this->fecha_inicio, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        $fechaFinalizacion   = Carbon::parse($this->fecha_finalizacion, 'UTC')->locale('es')->isoFormat('DD [de] MMMM [de] YYYY');
        return "Del $fechaInicio al $fechaFinalizacion";
    }
}
