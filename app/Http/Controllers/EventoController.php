<?php

namespace App\Http\Controllers;

use App\Models\AreaConocimiento;

use App\Models\InstitucionEducativa;
use App\Models\Evento;

use App\Http\Requests\EventoRequest;
use App\Models\DisciplinaSubareaConocimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [Evento::class, $institucionEducativa]);

        return Inertia::render('Eventos/Index', [
            'institucionEducativa'  => $institucionEducativa,
            'eventos'               => $institucionEducativa->eventos()->filterEvento(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [Evento::class, $institucionEducativa]);

        $areasConocimiento = AreaConocimiento::orderBy('nombre')->get();

        return Inertia::render('Eventos/Create', [
            'institucionEducativa'              => $institucionEducativa,
            'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventoRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [Evento::class, $institucionEducativa]);

        $evento = new Evento();
        $evento->nombre             = $request->nombre;
        $evento->ubicacion          = $request->ubicacion;
        $evento->descripcion        = $request->descripcion;
        $evento->fecha_inicio       = $request->fecha_inicio;
        $evento->fecha_finalizacion = $request->fecha_finalizacion;
        $evento->link_registro      = $request->link_registro;
        $evento->info_link          = $request->info_link;
        $evento->objetivos          = $request->objetivos;
        $evento->cronograma         = $request->cronograma;

        $departamento = $institucionEducativa->nodo->departamento;
        $year = date('Y', strtotime($request->fecha_finalizacion));

        if ($request->hasFile('imagen_principal')) {
            $file       = $request->file('imagen_principal');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$departamento-imagen_principal-$year.$extension";
            Storage::putFileAs(
                'public/eventos-imagenes-principales',
                $file,
                $fileName
            );

            $evento->imagen_principal  = "/eventos-imagenes-principales/$fileName";
        }

        if ($request->hasFile('afiche')) {
            $file       = $request->file('afiche');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$departamento-afiche-$year.$extension";
            Storage::putFileAs(
                'public/eventos-afiches',
                $file,
                $fileName
            );

            $evento->afiche  = "/eventos-afiches/$fileName";
        }

        $evento->institucionEducativa()->associate($institucionEducativa->id);

        $evento->save();
        $evento->disciplinasSubareaConocimiento()->attach($request->disciplina_subarea_conocimiento_id);

        return redirect()->route('instituciones-educativas.eventos.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, Evento $evento)
    {
        $this->authorize('view', [Evento::class, $institucionEducativa, $evento]);

        $evento->institucionEducativa;

        return Inertia::render('Eventos/Show', [
            'institucionEducativa'  => $institucionEducativa,
            'evento'                => $evento
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, Evento $evento)
    {
        $this->authorize('update', [Evento::class, $institucionEducativa, $evento]);

        return Inertia::render('Eventos/Edit', [
            'institucionEducativa'              => $institucionEducativa,
            'evento'                            => $evento,
            'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function update(EventoRequest $request, InstitucionEducativa $institucionEducativa, Evento $evento)
    {
        $this->authorize('update', [Evento::class, $institucionEducativa, $evento]);

        $evento->nombre             = $request->nombre;
        $evento->ubicacion          = $request->ubicacion;
        $evento->descripcion        = $request->descripcion;
        $evento->fecha_inicio       = $request->fecha_inicio;
        $evento->fecha_finalizacion = $request->fecha_finalizacion;
        $evento->link_registro      = $request->link_registro;
        $evento->info_link          = $request->info_link;
        $evento->objetivos          = $request->objetivos;
        $evento->cronograma         = $request->cronograma;

        $departamento = $institucionEducativa->nodo->departamento;
        $year = date('Y', strtotime($request->fecha_finalizacion));

        if ($request->hasFile('imagen_principal')) {
            Storage::delete("public/$evento->imagen_principal");

            $file       = $request->file('imagen_principal');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$departamento-imagen_principal-$year.$extension";
            Storage::putFileAs(
                'public/eventos-imagenes-principales',
                $file,
                $fileName
            );

            $evento->imagen_principal  = "/eventos-imagenes-principales/$fileName";
        }

        if ($request->hasFile('afiche')) {
            Storage::delete("public/$evento->afiche");
            $file       = $request->file('afiche');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$departamento-afiche-$year.$extension";
            Storage::putFileAs(
                'public/eventos-afiches',
                $file,
                $fileName
            );

            $evento->afiche  = "/eventos-afiches/$fileName";
        }
        $evento->institucionEducativa()->associate($institucionEducativa->id);

        $evento->save();

        $evento->disciplinasSubareaConocimiento()->sync($request->disciplina_subarea_conocimiento_id);

        return redirect()->route('instituciones-educativas.eventos.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, Evento $evento)
    {
        $this->authorize('delete', [Evento::class, $institucionEducativa, $evento]);

        $evento->delete();

        return redirect()->route('instituciones-educativas.eventos.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
