<?php

namespace App\Http\Controllers;

use App\Models\Estudio;

use App\Http\Requests\EstudioRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Estudios/Index', [
            'estudios' => auth()->user()->estudios()->filterEstudio(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Estudios/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstudioRequest $request)
    {
        $estudio = new Estudio();
        $estudio->graduado               = $request->get('graduado');
        $estudio->institucion_educativa  = $request->get('institucion_educativa');
        $estudio->programa_academico     = $request->get('programa_academico');
        $estudio->year                   = $request->get('year');
        $estudio->user()->associate(auth()->user()->id);

        $estudio->save();

        return redirect()->route('estudios.index')->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estudio $estudio
     * @return \Illuminate\Http\Response
     */
    public function show(Estudio $estudio)
    {
        $estudio->user;

        return Inertia::render('Estudios/Show', [
            'estudio' => $estudio
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Estudio $estudio
     * @return \Illuminate\Http\Response
     */
    public function edit(Estudio $estudio)
    {
        return Inertia::render('Estudios/Edit', [
            'estudio' => $estudio
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Estudio $estudio
     * @return \Illuminate\Http\Response
     */
    public function update(EstudioRequest $request, Estudio $estudio)
    {
        $estudio->graduado               = $request->get('graduado');
        $estudio->institucion_educativa  = $request->get('institucion_educativa');
        $estudio->programa_academico     = $request->get('programa_academico');
        $estudio->year                   = $request->get('year');
        $estudio->user()->associate(auth()->user()->id);

        $estudio->save();

        return redirect()->route('estudios.index')->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Estudio $estudio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudio $estudio)
    {
        $estudio->delete();

        return redirect()->route('estudios.index')->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
