<?php

namespace App\Http\Controllers;

use App\Http\Requests\FacultadRequest;
use App\Models\InstitucionEducativa;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FacultdadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [Facultad::class, $institucionEducativa]);

        return Inertia::render('Facultades/Index', [
            'institucionEducativa'  => $institucionEducativa,
            'facultades'            => $institucionEducativa->facultades()->orderBy('nombre', 'ASC')->filterFacultad(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [Facultad::class, $institucionEducativa]);

        return Inertia::render('Facultades/Create', [
            'institucionEducativa'  => $institucionEducativa,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FacultadRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [Facultad::class, $institucionEducativa]);

        $facultad = new Facultad();
        $facultad->nombre           = $request->nombre;
        $facultad->email            = $request->email;
        $facultad->numero_telefono  = $request->numero_telefono;

        // asociamos la facultad a una institucion
        $facultad->institucionEducativa()->associate($institucionEducativa);

        $facultad->save();

        return redirect()->route('instituciones-educativas.facultades.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, Facultad $facultad)
    {
        $this->authorize('view', [Facultad::class, $institucionEducativa, $facultad]);

        return Inertia::render('Facultades/Show', [
            'institucionEducativa' => $institucionEducativa,
            'facultad'             => $facultad
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, Facultad $facultad)
    {
        $this->authorize('update', [Facultad::class, $institucionEducativa, $facultad]);

        return Inertia::render('Facultades/Edit', [
            'institucionEducativa'  => $institucionEducativa,
            'facultad'              => $facultad
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */
    public function update(FacultadRequest $request, InstitucionEducativa $institucionEducativa, Facultad $facultad)
    {
        $this->authorize('update', [Facultad::class, $institucionEducativa, $facultad]);

        $facultad->nombre           = $request->nombre;
        $facultad->email            = $request->email;
        $facultad->numero_telefono  = $request->numero_telefono;

        $facultad->save();

        return redirect()->route('instituciones-educativas.facultades.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Facultad  $facultad
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, Facultad $facultad)
    {
        $this->authorize('delete', [Facultad::class, $institucionEducativa, $facultad]);

        $facultad->delete();

        return redirect()->route('instituciones-educativas.facultades.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
