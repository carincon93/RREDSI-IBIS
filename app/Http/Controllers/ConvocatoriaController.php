<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConvocatoriaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ConvocatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [Convocatoria::class]);

        return Inertia::render('Convocatorias/Index', [
            'convocatorias' => Convocatoria::filterConvocatoria(request()->only('search'))->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [Convocatoria::class]);

        return Inertia::render('Convocatorias/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConvocatoriaRequest $request)
    {
        $this->authorize('create', [Convocatoria::class]);

        $convocatoria = new Convocatoria();
        $convocatoria->nombre               = $request->nombre;
        $convocatoria->entidad              = $request->entidad;
        $convocatoria->detalles             = $request->detalles;
        $convocatoria->fecha_inicio         = $request->fecha_inicio;
        $convocatoria->fecha_finalizacion   = $request->fecha_finalizacion;
        $convocatoria->link_mas_informacion = $request->link_mas_informacion;
        $convocatoria->autor()->associate(auth()->user()->id);

        $file = $request->image;

        if ($request->hasFile('image')) {

            $file = $request->file('image')->store('imagenes-convocatoria', 'public');
            $convocatoria->image = $file;
        }

        if ($convocatoria->save()) {
            return redirect()->back()->with('success', 'Convocatoria agregada con exito');
        } else {

            return redirect()->back()->with('error', 'Hubo un error al agregar la convocatoria');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function show(Convocatoria $convocatoria)
    {
        $this->authorize('view', [Convocatoria::class, $convocatoria]);

        return Inertia::render('Convocatorias/Show', [
            'convocatoria' => $convocatoria
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Convocatoria $convocatoria)
    {
        $this->authorize('update', [Convocatoria::class, $convocatoria]);

        return Inertia::render('Convocatorias/Edit', [
            'convocatoria' => $convocatoria
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function update(ConvocatoriaRequest $request, Convocatoria $convocatoria)
    {
        $this->authorize('update', [Convocatoria::class, $convocatoria]);

        $convocatoria->nombre               = $request->nombre;
        $convocatoria->entidad              = $request->entidad;
        $convocatoria->detalles             = $request->detalles;
        $convocatoria->fecha_inicio         = $request->fecha_inicio;
        $convocatoria->fecha_finalizacion   = $request->fecha_finalizacion;
        $convocatoria->link_mas_informacion = $request->link_mas_informacion;

        $file = $request->image;

        if ($request->hasFile('image')) {
            Storage::delete("public/$convocatoria->image");
            $file = $request->file('image')->store('imagenes-convocatoria', 'public');
            $convocatoria->image = $file;
        }

        if ($convocatoria->save()) {
            return redirect()->back()->with('success', 'Convocatoria editada correctamente');
        } else {
            return redirect()->back()->with('error', 'Hubo un error al editar la convocatoria');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Convocatoria  $convocatoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Convocatoria $convocatoria)
    {
        $this->authorize('delete', [Convocatoria::class, $convocatoria]);

        $convocatoria->delete();

        return redirect()->redirect('convocatorias.index')->with('success', 'Convocatoria eliminada correctamente');
    }
}
