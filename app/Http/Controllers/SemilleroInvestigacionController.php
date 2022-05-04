<?php

namespace App\Http\Controllers;

use App\Models\SubareaConocimiento;

use App\Models\InstitucionEducativa;
use App\Models\SemilleroInvestigacion;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotificacionGeneral;
use App\Http\Requests\SemilleroInvestigacionRequest;
use App\Models\DisciplinaSubareaConocimiento;
use App\Models\GrupoInvestigacion;
use App\Models\LineaInvestigacion;
use App\Models\ProgramaAcademico;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SemilleroInvestigacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [SemilleroInvestigacion::class, $institucionEducativa]);

        return Inertia::render('SemillerosInvestigacion/Index', [
            'institucionEducativa'      => $institucionEducativa,
            'semillerosInvestigacion'   => SemilleroInvestigacion::select('semilleros_investigacion.id', 'semilleros_investigacion.nombre', 'semilleros_investigacion.grupo_investigacion_id')->orderBy('semilleros_investigacion.nombre')->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->filterSemilleroInvestigacion(request()->only('search'))->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [SemilleroInvestigacion::class, $institucionEducativa]);

        return Inertia::render('SemillerosInvestigacion/Create', [
            'institucionEducativa'              => $institucionEducativa,
            'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
            'programasAcademicos'               => ProgramaAcademico::select('programas_academicos.id as value', 'programas_academicos.nombre as label')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('programas_academicos.nombre')->get(),
            'gruposInvestigacion'               => GrupoInvestigacion::select('grupos_investigacion.id as value', 'grupos_investigacion.nombre as label')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('grupos_investigacion.nombre')->get(),
            'lineasInvestigacion'               => LineaInvestigacion::select('lineas_investigacion.id as value', 'lineas_investigacion.nombre as label')->join('grupos_investigacion', 'lineas_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('lineas_investigacion.nombre')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SemilleroInvestigacionRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [SemilleroInvestigacion::class, $institucionEducativa]);

        $semilleroInvestigacion = new SemilleroInvestigacion();
        $semilleroInvestigacion->nombre                             = $request->nombre;
        $semilleroInvestigacion->nombre_mentor                      = $request->nombre_mentor;
        $semilleroInvestigacion->correo_mentor                      = $request->correo_mentor;
        $semilleroInvestigacion->celular_mentor                     = $request->celular_mentor;
        $semilleroInvestigacion->objetivo_general                   = $request->objetivo_general;
        $semilleroInvestigacion->mision                             = $request->mision;
        $semilleroInvestigacion->vision                             = $request->vision;
        $semilleroInvestigacion->proyeccion_regional                = $request->proyeccion_regional;
        $semilleroInvestigacion->estrategia_produccion_conocimiento = $request->estrategia_produccion_conocimiento;
        $semilleroInvestigacion->tematica_investigacion             = $request->tematica_investigacion;
        $semilleroInvestigacion->fecha_creacion                     = $request->fecha_creacion;

        $semilleroInvestigacion->grupoInvestigacion()->associate($request->grupo_investigacion_id);

        $semilleroInvestigacion->save();
        $semilleroInvestigacion->programasAcademicos()->attach($request->programa_academico_id);
        $semilleroInvestigacion->disciplinasSubareaConocimiento()->attach($request->disciplina_subarea_conocimiento_id);
        $semilleroInvestigacion->lineasInvestigacion()->attach($request->linea_investigacion_id);

        return redirect()->route('instituciones-educativas.semilleros-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SemilleroInvestigacion  $semilleroInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, SemilleroInvestigacion $semilleroInvestigacion)
    {
        $this->authorize('view', [SemilleroInvestigacion::class, $institucionEducativa, $semilleroInvestigacion]);

        $semilleroInvestigacion->grupoInvestigacion;
        $semilleroInvestigacion->lineasInvestigacion;
        $semilleroInvestigacion->programasAcademicos;
        $semilleroInvestigacion->disciplinasSubareaConocimiento;

        $semilleroInvestigacion->tematica_investigacion = json_decode($semilleroInvestigacion->tematica_investigacion);

        return Inertia::render('SemillerosInvestigacion/Show', [
            'institucionEducativa'      => $institucionEducativa,
            'semilleroInvestigacion'    => $semilleroInvestigacion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SemilleroInvestigacion  $semilleroInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, SemilleroInvestigacion $semilleroInvestigacion)
    {
        $this->authorize('update', [SemilleroInvestigacion::class, $institucionEducativa, $semilleroInvestigacion]);

        return Inertia::render('SemillerosInvestigacion/Edit', [
            'institucionEducativa'              => $institucionEducativa,
            'semilleroInvestigacion'            => $semilleroInvestigacion,
            'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
            'disciplinasRelacionadas'           => $semilleroInvestigacion->disciplinasSubareaConocimiento()->select('disciplinas_subarea_conocimiento.id as value', 'disciplinas_subarea_conocimiento.nombre as label')->get(),
            'programasAcademicos'               => ProgramaAcademico::select('programas_academicos.id as value', 'programas_academicos.nombre as label')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('programas_academicos.nombre')->get(),
            'programasAcademicosRelacionados'   => $semilleroInvestigacion->programasAcademicos()->select('programas_academicos.id as value', 'programas_academicos.nombre as label')->get(),
            'gruposInvestigacion'               => GrupoInvestigacion::select('grupos_investigacion.id as value', 'grupos_investigacion.nombre as label')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('grupos_investigacion.nombre')->get(),
            'lineasInvestigacion'               => LineaInvestigacion::select('lineas_investigacion.id as value', 'lineas_investigacion.nombre as label')->join('grupos_investigacion', 'lineas_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('lineas_investigacion.nombre')->get(),
            'lineasInvestigacionRelacionadas'   => $semilleroInvestigacion->lineasInvestigacion()->select('lineas_investigacion.id as value', 'lineas_investigacion.nombre as label')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SemilleroInvestigacion  $semilleroInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function update(SemilleroInvestigacionRequest $request, InstitucionEducativa $institucionEducativa, SemilleroInvestigacion $semilleroInvestigacion)
    {
        $this->authorize('update', [SemilleroInvestigacion::class, $institucionEducativa, $semilleroInvestigacion]);

        $semilleroInvestigacion->nombre                             = $request->nombre;
        $semilleroInvestigacion->nombre_mentor                      = $request->nombre_mentor;
        $semilleroInvestigacion->correo_mentor                      = $request->correo_mentor;
        $semilleroInvestigacion->celular_mentor                     = $request->celular_mentor;
        $semilleroInvestigacion->objetivo_general                   = $request->objetivo_general;
        $semilleroInvestigacion->mision                             = $request->mision;
        $semilleroInvestigacion->vision                             = $request->vision;
        $semilleroInvestigacion->proyeccion_regional                = $request->proyeccion_regional;
        $semilleroInvestigacion->estrategia_produccion_conocimiento = $request->estrategia_produccion_conocimiento;
        $semilleroInvestigacion->tematica_investigacion             = $request->tematica_investigacion;
        $semilleroInvestigacion->fecha_creacion                     = $request->fecha_creacion;

        $semilleroInvestigacion->grupoInvestigacion()->associate($request->grupo_investigacion_id);

        $semilleroInvestigacion->save();
        $semilleroInvestigacion->programasAcademicos()->sync($request->programa_academico_id);
        $semilleroInvestigacion->disciplinasSubareaConocimiento()->sync($request->disciplina_subarea_conocimiento_id);
        $semilleroInvestigacion->lineasInvestigacion()->sync($request->linea_investigacion_id);

        return redirect()->route('instituciones-educativas.semilleros-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SemilleroInvestigacion  $semilleroInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, SemilleroInvestigacion $semilleroInvestigacion)
    {
        $this->authorize('delete', [SemilleroInvestigacion::class, $institucionEducativa, $semilleroInvestigacion]);

        $semilleroInvestigacion->delete();

        return redirect()->route('instituciones-educativas.semilleros-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }

    public function integrantes(InstitucionEducativa $institucionEducativa, SemilleroInvestigacion $semilleroInvestigacion)
    {
        $this->authorize('view', [SemilleroInvestigacion::class, $institucionEducativa, $semilleroInvestigacion]);

        return redirect()->route('users.index', ['institucionEducativaId=' . $institucionEducativa->id, 'semilleroId=' . $semilleroInvestigacion->id]);
    }
}
