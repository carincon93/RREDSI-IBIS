<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InstitucionEducativa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'delegado_id',
        'nodo_id',
        'nombre',
        'logo',
        'nit',
        'direccion',
        'ciudad',
        'numero_telefono',
        'sitio_web',
    ];

    /**
     * table
     *
     * @var string
     */
    protected $table = 'instituciones_educativas';

    public function nodo()
    {
        return $this->belongsTo(Nodo::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function facultades()
    {
        return $this->hasMany(Facultad::class);
    }

    public function eventosRredsiDepartamental()
    {
        return $this->hasMany(EventoRredsiDepartamental::class);
    }

    public function eventos()
    {
        return $this->hasMany(Evento::class);
    }

    public function delegado()
    {
        return $this->belongsTo(User::class, 'delegado_id');
    }

    // Empresa Analytics
    public function proyectosByAreaConocimiento()
    {
        $industriasCreativas = 0;
        $cienciasNaturales = 0;
        $ingenieriaTecnologia = 0;
        $cuartaRevolucionIndustrial = 0;
        $cienciasMedicasSalud = 0;
        $cienciasAgricolas = 0;
        $cienciasVeterinarias = 0;
        $cienciasSociales = 0;
        $humanidades = 0;

        foreach ($this->facultades as $facultad) {
            foreach ($facultad->gruposInvestigacion as $grupoInvestigacion) {
                foreach ($grupoInvestigacion->semillerosInvestigacion as $semilleroInvestigacion) {
                    foreach ($semilleroInvestigacion->proyectos as $proyecto) {
                        foreach ($proyecto->disciplinasSubareaConocimiento as $disciplinaSubareaConocimiento) {
                            switch ($disciplinaSubareaConocimiento->subareaConocimiento->areaConocimiento->nombre) {
                                case 'Industrias creativas':
                                    $industriasCreativas++;
                                    break;
                                case 'Ciencias naturales':
                                    $cienciasNaturales++;
                                    break;
                                case 'Ingeniería y tecnología':
                                    $ingenieriaTecnologia++;
                                    break;
                                case 'Cuarta revolución industrial':
                                    $cuartaRevolucionIndustrial++;
                                    break;
                                case 'Ciencias médicas y de salud':
                                    $cienciasMedicasSalud++;
                                    break;
                                case 'Ciencias agrícolas':
                                    $cienciasAgricolas++;
                                    break;
                                case 'Ciencias veterinarias':
                                    $cienciasVeterinarias++;
                                    break;
                                case 'Ciencias sociales':
                                    $cienciasSociales++;
                                    break;
                                case 'Humanidades':
                                    $humanidades++;
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                }
            }
        }

        return $proyectosByAreaConocimiento = collect([
            'industriasCreativas' => $industriasCreativas,
            'cienciasNaturales' => $cienciasNaturales,
            'ingenieriaTecnologia' => $ingenieriaTecnologia,
            'cuartaRevolucionIndustrial' => $cuartaRevolucionIndustrial,
            'cienciasMedicasSalud' => $cienciasMedicasSalud,
            'cienciasAgricolas' => $cienciasAgricolas,
            'cienciasVeterinarias' => $cienciasVeterinarias,
            'cienciasSociales' => $cienciasSociales,
            'humanidades' => $humanidades,
        ]);
    }

    public function proyectosByTipoProyectos()
    {
        $investigacionAplicada  = 0;
        $investigacionBasica    = 0;
        $desarrolloTecnologico  = 0;

        foreach ($this->facultades as $facultad) {
            foreach ($facultad->gruposInvestigacion as $grupoInvestigacion) {
                foreach ($grupoInvestigacion->semillerosInvestigacion as $semilleroInvestigacion) {
                    foreach ($semilleroInvestigacion->proyectos as $proyecto) {
                        switch ($proyecto->tipoProyecto->tipo) {
                            case 'investigación aplicada':
                                $investigacionAplicada++;
                                break;
                            case 'investigación básica':
                                $investigacionBasica++;
                                break;
                            case 'desarrollo tecnológico':
                                $desarrolloTecnologico++;
                                break;
                            default:
                                break;
                        }
                    }
                }
            }
        }

        return $proyectosByTipoProyectos = collect([
            'investigacionAplicada' => $investigacionAplicada,
            'investigacionBasica'   => $investigacionBasica,
            'desarrolloTecnologico' => $desarrolloTecnologico,
        ]);
    }

    public function proyectosByYear()
    {
        return DB::table('proyectos')->select(DB::raw("date_part('year', proyectos.fecha_finalizacion), COUNT(date_part('year', proyectos.fecha_finalizacion))"))->join("proyecto_semillero_investigacion", "proyectos.id", "proyecto_semillero_investigacion.proyecto_id")->join("semilleros_investigacion", "proyecto_semillero_investigacion.semillero_investigacion_id", "semilleros_investigacion.id")->join("grupos_investigacion", "semilleros_investigacion.grupo_investigacion_id", "grupos_investigacion.id")->join("facultades", "grupos_investigacion.facultad_id", "facultades.id")->join("instituciones_educativas", "facultades.institucion_educativa_id", "instituciones_educativas.id")->where("instituciones_educativas.id", $this->id)->groupBy(DB::raw("date_part('year', proyectos.fecha_finalizacion)"))->get();
    }

    public function qtyGraduacionesInfo()
    {
        return DB::table('estudios')->select(DB::raw('count(DISTINCT miembros_facultad.user_id)'))->join('miembros_facultad', 'estudios.user_id', 'miembros_facultad.user_id')->join("facultades", "miembros_facultad.facultad_id", "facultades.id")->join("instituciones_educativas", "facultades.institucion_educativa_id", "instituciones_educativas.id")->where('instituciones_educativas.id', $this->id)->count();
    }

    public function qtySemillerosInvestigacion()
    {
        return DB::table('semilleros_investigacion')
            ->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')
            ->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $this->id)->count();
    }

    public function qtyGruposInvestigacion()
    {
        return DB::table('grupos_investigacion')
            ->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $this->id)->count();
    }

    public function qtyAmbientesFormacion()
    {
        return DB::table('ambientes_formacion')
            ->join('facultades', 'ambientes_formacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $this->id)->count();
    }

    public function qtyProyectos()
    {
        return DB::table('proyectos')
            ->join('proyecto_semillero_investigacion', 'proyectos.id', 'proyecto_semillero_investigacion.proyecto_id')
            ->join('semilleros_investigacion', 'proyecto_semillero_investigacion.semillero_investigacion_id', 'semilleros_investigacion.id')
            ->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')
            ->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $this->id)->count();
    }

    public function qtyProgramasAcademico()
    {
        return DB::table('programas_academicos')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $this->id)->count();
    }

    public function qtyUsers()
    {
        return DB::table('users')
            ->join('miembros_facultad', 'users.id', 'miembros_facultad.user_id')
            ->join('facultades', 'miembros_facultad.facultad_id', 'facultades.id')
            ->where('facultades.institucion_educativa_id', $this->id)->count();
    }

    public function qtyEventos()
    {
        return DB::table('eventos_institucion_educativa')->where('eventos_institucion_educativa.institucion_educativa_id', $this->id)->count();
    }

    public function eventosProyectos()
    {
        return DB::table('eventos_institucion_educativa')->select(DB::raw('eventos.name, count(evento_proyecto.evento_id)'))->join('eventos', 'eventos_institucion_educativa.id', 'eventos.id')->join('evento_proyecto', 'eventos.id', 'evento_proyecto.evento_id')->where('eventos_institucion_educativa.institucion_educativa_id', $this->id)->groupBy('evento_proyecto.evento_id', 'eventos.name')->get();
    }

    /**
     * Filtrar registros
     *
     * @param  mixed $query
     * @param  mixed $filters
     * @return void
     */
    public function scopeFilterInstitucionEducativa($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('nombre', 'like', '%' . $search . '%');
        });
    }
}
