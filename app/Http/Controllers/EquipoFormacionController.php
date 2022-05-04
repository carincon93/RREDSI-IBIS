<?php

namespace App\Http\Controllers;

use App\Models\InstitucionEducativa;
use App\Models\EquipoFormacion;

use App\Http\Requests\EquipoFormacionRequest;
use App\Models\DisciplinaSubareaConocimiento;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EquipoFormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [EquipoFormacion::class, $institucionEducativa]);

        return Inertia::render(
            'EquiposFormacion/Index',
            [
                'institucionEducativa'  => $institucionEducativa,
                'equiposFormacion'      => EquipoFormacion::select('equipos_formacion.id', 'equipos_formacion.nombre', 'equipos_formacion.facultad_id')->orderBy('equipos_formacion.nombre', 'ASC')->join('facultades', 'equipos_formacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->filterEquipoFormacion(request()->only('search'))->paginate(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [EquipoFormacion::class, $institucionEducativa]);

        return Inertia::render(
            'EquiposFormacion/Create',
            [
                'institucionEducativa'              => $institucionEducativa,
                'facultades'                        => Facultad::select('id as value', 'nombre as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('nombre')->get(),
                'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EquipoFormacionRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [EquipoFormacion::class, $institucionEducativa]);

        $equipoFormacion = new EquipoFormacion();
        $equipoFormacion->nombre                = $request->nombre;
        $equipoFormacion->descripcion           = $request->descripcion;
        $equipoFormacion->nombre_responsable    = $request->nombre_responsable;
        $equipoFormacion->correo_responsable    = $request->correo_responsable;
        $equipoFormacion->celular_responsable   = $request->celular_responsable;

        if ($request->hasFile('foto')) {
            $file       = $request->file('foto');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($equipoFormacion->nombre, 0, 20)) . "-RREDSI-foto" . time() . $extension;
            Storage::putFileAs(
                'public/fotos-equipos-formacion',
                $file,
                $fileName
            );

            $equipoFormacion->foto  = "fotos-equipos-formacion/$fileName";
        }

        // asociamos la herramienta educativa al ambiente de formación
        $equipoFormacion->facultad()->associate($request->facultad_id);

        if ($equipoFormacion->save()) {
            $equipoFormacion->disciplinasSubareaConocimiento()->attach($request->disciplina_subarea_conocimiento_id);
        }

        return redirect()->route('instituciones-educativas.equipos-formacion.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EquipoFormacion  $equipoFormacion
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, EquipoFormacion $equipoFormacion)
    {
        $this->authorize('view', [EquipoFormacion::class, $institucionEducativa, $equipoFormacion]);

        $equipoFormacion->facultad;
        $equipoFormacion->disciplinasSubareaConocimiento;
        $equipoFormacion->facultad->institucionEducativa->delegado;

        return Inertia::render(
            'EquiposFormacion/Show',
            [
                'institucionEducativa'  => $institucionEducativa,
                'equipoFormacion'       => $equipoFormacion
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EquipoFormacion  $equipoFormacion
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, EquipoFormacion $equipoFormacion)
    {
        $this->authorize('update', [EquipoFormacion::class, $institucionEducativa, $equipoFormacion]);

        return Inertia::render(
            'EquiposFormacion/Edit',
            [
                'institucionEducativa'              => $institucionEducativa,
                'equipoFormacion'                   => $equipoFormacion,
                'facultades'                        => Facultad::select('id as value', 'nombre as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('nombre')->get(),
                'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
                'disciplinasRelacionadas'           => $equipoFormacion->disciplinasSubareaConocimiento()->select('disciplinas_subarea_conocimiento.id as value', 'disciplinas_subarea_conocimiento.nombre as label')->get(),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EquipoFormacion  $equipoFormacion
     * @return \Illuminate\Http\Response
     */
    public function update(EquipoFormacionRequest $request, InstitucionEducativa $institucionEducativa, EquipoFormacion $equipoFormacion)
    {
        $this->authorize('update', [EquipoFormacion::class, $institucionEducativa, $equipoFormacion]);

        $equipoFormacion->nombre                = $request->nombre;
        $equipoFormacion->descripcion           = $request->descripcion;
        $equipoFormacion->nombre_responsable    = $request->nombre_responsable;
        $equipoFormacion->correo_responsable    = $request->correo_responsable;
        $equipoFormacion->celular_responsable   = $request->celular_responsable;

        if ($request->hasFile('foto')) {
            Storage::delete("public/$equipoFormacion->foto");
            $file       = $request->file('foto');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($equipoFormacion->nombre, 0, 20)) . "-RREDSI-foto" . time() . $extension;
            Storage::putFileAs(
                'public/fotos-equipos-formacion',
                $file,
                $fileName
            );

            $equipoFormacion->foto  = "fotos-equipos-formacion/$fileName";
        }

        // asociamos la herramienta educativa al ambiente de formación
        $equipoFormacion->facultad()->associate($request->facultad_id);

        if ($equipoFormacion->save()) {
            $equipoFormacion->disciplinasSubareaConocimiento()->sync($request->disciplina_subarea_conocimiento_id);
        }

        return redirect()->route('instituciones-educativas.equipos-formacion.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EquipoFormacion  $equipoFormacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, EquipoFormacion $equipoFormacion)
    {
        $this->authorize('delete', [EquipoFormacion::class, $institucionEducativa, $equipoFormacion]);

        $equipoFormacion->delete();

        return redirect()->route('instituciones-educativas.equipos-formacion.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
