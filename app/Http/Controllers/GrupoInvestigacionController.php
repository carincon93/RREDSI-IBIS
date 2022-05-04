<?php

namespace App\Http\Controllers;

use App\Models\InstitucionEducativa;
use App\Models\GrupoInvestigacion;

use App\Http\Requests\GrupoInvestigacionRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GrupoInvestigacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [GrupoInvestigacion::class, $institucionEducativa]);

        return Inertia::render('GruposInvestigacion/Index', [
            'institucionEducativa'  => $institucionEducativa,
            'gruposInvestigacion'   => GrupoInvestigacion::orderBy('nombre')->filterGrupoInvestigacion(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [GrupoInvestigacion::class, $institucionEducativa]);

        return Inertia::render('GruposInvestigacion/Create', [
            'institucionEducativa'  => $institucionEducativa,
            'facultades'            => $institucionEducativa->facultades()->select('id as value', 'nombre as label')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoInvestigacionRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [GrupoInvestigacion::class, $institucionEducativa]);

        $grupoInvestigacion = new GrupoInvestigacion();
        $grupoInvestigacion->nombre                 = $request->nombre;
        $grupoInvestigacion->email                  = $request->email;
        $grupoInvestigacion->lider                  = $request->lider;
        $grupoInvestigacion->gruplac                = $request->gruplac;
        $grupoInvestigacion->codigo_minciencias     = $request->codigo_minciencias;
        $grupoInvestigacion->categoria_minciencias  = $request->categoria_minciencias;
        $grupoInvestigacion->sitio_web              = $request->sitio_web;
        $grupoInvestigacion->facultad()->associate($request->facultad_id);

        $grupoInvestigacion->save();

        return redirect()->route('instituciones-educativas.grupos-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GrupoInvestigacion  $grupoInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, GrupoInvestigacion $grupoInvestigacion)
    {
        $this->authorize('view', [GrupoInvestigacion::class, $institucionEducativa, $grupoInvestigacion]);

        $grupoInvestigacion->facultad;

        return Inertia::render('GruposInvestigacion/Show', [
            'institucionEducativa'  => $institucionEducativa,
            'grupoInvestigacion'    => $grupoInvestigacion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GrupoInvestigacion  $grupoInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, GrupoInvestigacion $grupoInvestigacion)
    {
        $this->authorize('update', [GrupoInvestigacion::class, $institucionEducativa, $grupoInvestigacion]);

        return Inertia::render('GruposInvestigacion/Edit', [
            'institucionEducativa'  => $institucionEducativa,
            'grupoInvestigacion'    => $grupoInvestigacion,
            'facultades'            => $institucionEducativa->facultades()->select('id as value', 'nombre as label')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GrupoInvestigacion  $grupoInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoInvestigacionRequest $request, InstitucionEducativa $institucionEducativa, GrupoInvestigacion $grupoInvestigacion)
    {
        $this->authorize('update', [GrupoInvestigacion::class, $institucionEducativa, $grupoInvestigacion]);

        $grupoInvestigacion->nombre                 = $request->nombre;
        $grupoInvestigacion->email                  = $request->email;
        $grupoInvestigacion->lider                  = $request->lider;
        $grupoInvestigacion->gruplac                = $request->gruplac;
        $grupoInvestigacion->codigo_minciencias     = $request->codigo_minciencias;
        $grupoInvestigacion->categoria_minciencias  = $request->categoria_minciencias;
        $grupoInvestigacion->sitio_web              = $request->sitio_web;
        $grupoInvestigacion->facultad()->associate($request->facultad_id);

        $grupoInvestigacion->save();

        return redirect()->route('instituciones-educativas.grupos-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GrupoInvestigacion  $grupoInvestigacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, GrupoInvestigacion $grupoInvestigacion)
    {
        $this->authorize('delete', [GrupoInvestigacion::class, $institucionEducativa, $grupoInvestigacion]);

        $grupoInvestigacion->delete();

        return redirect()->route('instituciones-educativas.grupos-investigacion.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
