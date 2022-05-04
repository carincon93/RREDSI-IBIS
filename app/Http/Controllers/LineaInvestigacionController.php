<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\Models\InstitucionEducativa;
use App\Models\Facultad;
use App\Models\GrupoInvestigacion;
use App\Models\LineaInvestigacion;
use App\Models\AreaConocimiento;

use App\Http\Requests\LineaInvestigacionRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LineaInvestigacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [LineaInvestigacion::class, $institucionEducativa]);

        return Inertia::render('LineasInvestigacion/Index', [
            'institucionEducativa'  => $institucionEducativa,
            'lineasInvestigacion'   => LineaInvestigacion::select('lineas_investigacion.id', 'lineas_investigacion.nombre', 'lineas_investigacion.grupo_investigacion_id')->orderBy('lineas_investigacion.nombre')->join('grupos_investigacion', 'lineas_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->filterLineaInvestigacion(request()->only('search'))->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [LineaInvestigacion::class, $institucionEducativa]);

        return Inertia::render('LineasInvestigacion/Create', [
            'institucionEducativa' => $institucionEducativa,
            'areasConocimiento'    => AreaConocimiento::select('id as value', 'nombre as label')->orderBy('nombre')->get(),
            'gruposInvestigacion'  => GrupoInvestigacion::select('grupos_investigacion.id as value', 'grupos_investigacion.nombre as label')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('grupos_investigacion.nombre')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineaInvestigacionRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [LineaInvestigacion::class, $institucionEducativa]);

        $lineaInvestigacion = new LineaInvestigacion();
        $lineaInvestigacion->nombre       = $request->nombre;
        $lineaInvestigacion->objetivos    = $request->objetivos;
        $lineaInvestigacion->mision       = $request->mision;
        $lineaInvestigacion->vision       = $request->vision;
        $lineaInvestigacion->logros       = $request->logros;
        $lineaInvestigacion->areaConocimiento()->associate($request->area_conocimiento_id);
        $lineaInvestigacion->grupoInvestigacion()->associate($request->grupo_investigacion_id);

        $lineaInvestigacion->save();

        return redirect()->route('instituciones-educativas.lineas-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LineaInvestigacion  $lineaInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, LineaInvestigacion $lineaInvestigacion)
    {
        $this->authorize('view', [LineaInvestigacion::class, $institucionEducativa, $lineaInvestigacion]);

        $lineaInvestigacion->grupoInvestigacion;

        return Inertia::render('LineasInvestigacion/Show', [
            'institucionEducativa'  => $institucionEducativa,
            'lineaInvestigacion'    => $lineaInvestigacion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LineaInvestigacion  $lineaInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, LineaInvestigacion $lineaInvestigacion)
    {
        $this->authorize('update', [LineaInvestigacion::class, $institucionEducativa, $lineaInvestigacion]);

        return Inertia::render('LineasInvestigacion/Edit', [
            'institucionEducativa'  => $institucionEducativa,
            'lineaInvestigacion'    => $lineaInvestigacion,
            'areasConocimiento'     => AreaConocimiento::select('id as value', 'nombre as label')->orderBy('nombre')->get(),
            'gruposInvestigacion'   => GrupoInvestigacion::select('grupos_investigacion.id as value', 'grupos_investigacion.nombre as label')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('grupos_investigacion.nombre')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LineaInvestigacion  $lineaInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function update(LineaInvestigacionRequest $request, InstitucionEducativa $institucionEducativa, LineaInvestigacion $lineaInvestigacion)
    {
        $this->authorize('update', [LineaInvestigacion::class, $institucionEducativa, $lineaInvestigacion]);

        $lineaInvestigacion->nombre     = $request->nombre;
        $lineaInvestigacion->objetivos  = $request->objetivos;
        $lineaInvestigacion->mision     = $request->mision;
        $lineaInvestigacion->vision     = $request->vision;
        $lineaInvestigacion->logros     = $request->logros;
        $lineaInvestigacion->areaConocimiento()->associate($request->area_conocimiento_id);
        $lineaInvestigacion->grupoInvestigacion()->associate($request->grupo_investigacion_id);

        $lineaInvestigacion->save();

        return redirect()->route('instituciones-educativas.lineas-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LineaInvestigacion  $lineaInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, LineaInvestigacion $lineaInvestigacion)
    {
        $this->authorize('delete', [LineaInvestigacion::class, $institucionEducativa, $lineaInvestigacion]);

        $lineaInvestigacion->delete();

        return redirect()->route('instituciones-educativas.lineas-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
