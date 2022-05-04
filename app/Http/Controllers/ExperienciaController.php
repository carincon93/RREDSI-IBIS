<?php

namespace App\Http\Controllers;

use App\Models\Experiencia;
use App\Models\Empresa;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienciaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ExperienciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [Experiencia::class]);

        $user    = auth()->user();
        $empresa = $user->empresa()->first();

        return Inertia::render('Experiencias/Index', [
            'experiencias' => Experiencia::where('empresa_id', '=', $empresa ? $empresa->id : null)->filterExperiencia(request()->only('search'))->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [Experiencia::class]);

        return Inertia::render('Experiencias/Create');
    }

    public function store(ExperienciaRequest $request)
    {
        $this->authorize('create', [Experiencia::class]);

        if (auth()->user()->empresa()->first()) {

            $experiencia = new Experiencia();
            $experiencia->titulo       = $request->titulo;
            $experiencia->descripcion  = $request->descripcion;
            $experiencia->empresa()->associate(auth()->user()->empresa()->first()->id);

            $file = $request->image;

            if ($request->hasFile('image')) {
                $file = $request->file('image')->store('imagenes-experiencias', 'public');
                $experiencia->image = $file;
            }

            if ($experiencia->save()) {
                return redirect()->back()->with('success', 'Experiencia agregada con correctamente');
            } else {
                return redirect()->back()->with('error', 'Hubo un error al agregar la experiencia');
            }
        } else {
            return redirect()->back()->with('error', 'No está asociado a ninguna empresa. Por favor comuníquese con el administrador del sistema.');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Experiencia $experiencia)
    {
        $this->authorize('create', [Experiencia::class, $experiencia]);

        return Inertia::render('Experiencias/Show', [
            'experiencia' => $experiencia
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Experiencia  $experiencia
     * @return \Illuminate\Http\Response
     */
    public function edit(Experiencia $experiencia)
    {
        $this->authorize('update', [Experiencia::class, $experiencia]);

        return Inertia::render('Experiencias/Edit', [
            'experiencia' => $experiencia
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Experiencia  $experiencia
     * @return \Illuminate\Http\Response
     */
    public function update(ExperienciaRequest $request, Experiencia $experiencia)
    {
        $this->authorize('update', [Experiencia::class, $experiencia]);

        $experiencia->titulo      = $request->titulo;
        $experiencia->descripcion = $request->descripcion;

        $file = $request->image;

        if ($request->hasFile('image')) {
            Storage::delete("public/$experiencia->image");
            $file = $request->file('image')->store('imagenes-experiencias', 'public');
            $experiencia->image = $file;
        }

        if ($experiencia->save()) {
            return redirect()->back()->with('success', 'Experiencia modificada con correctamente');
        } else {
            return redirect()->back()->with('error', 'Hubo un error al modificar la experiencia');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experiencia  $experiencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experiencia $experiencia)
    {
        $this->authorize('delete', [Experiencia::class, $experiencia]);

        Storage::delete('public/' . $experiencia->image);

        $experiencia->delete();

        return redirect()->route('experiencias.index')->with('success', 'Experiencia eliminada correctamente');
    }

    public function buscarExperiencias()
    {
        $user    = auth()->user();
        $empresa = $user->empresa()->first();

        return Inertia::render('Experiencias/TodasExperiencias', [
            'experiencias' => Experiencia::filterExperiencia(request()->only('search'))->paginate()
        ]);
    }
}
