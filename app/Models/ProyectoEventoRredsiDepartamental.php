<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoEventoRredsiDepartamental extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'evento_rredsi_departamental_id',
        'primer_ponente_id',
        'segundo_ponente_id',
        'programa_academico_primer_ponente_id',
        'programa_academico_segundo_ponente_id',
        'proyecto_id',
        'semillero_investigacion_id',
        'tipo_presentacion',
        'modalidad_proyecto',
        'carta_aval',
        'carta_poster',
        'documento_proyecto_finalizado',
        'autorizacion_memorias',
        'autorizacion_tratamiento_datos',
        'area_conocimiento',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'proyecto_evento_rredsi_departamental';

    public function eventoRredsiDepartamental()
    {
        return $this->belongsTo(EventoRredsiDepartamental::class, 'evento_rredsi_departamental_id');
    }

    public function primerPonente()
    {
        return $this->belongsTo(User::class, 'primer_ponente_id');
    }

    public function segundoPonente()
    {
        return $this->belongsTo(User::class, 'segundo_ponente_id');
    }

    public function programaAcademicoPrimerPonente()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_academico_primer_ponente_id');
    }

    public function programaAcademicoSegundoPonente()
    {
        return $this->belongsTo(ProgramaAcademico::class, 'programa_academico_segundo_ponente_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function semilleroInvestigacion()
    {
        return $this->belongsTo(SemilleroInvestigacion::class);
    }
}
