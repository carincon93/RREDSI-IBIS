<?php

namespace App\Http\Controllers;

use App\Models\InstitucionEducativa;
use App\Models\AmbienteFormacion;

use App\Http\Requests\AmbienteFormacionRequest;
use App\Models\DisciplinaSubareaConocimiento;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class AmbienteFormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [AmbienteFormacion::class, $institucionEducativa]);

        return Inertia::render('AmbientesFormacion/Index', [
            'institucionEducativa' => $institucionEducativa,
            'ambientesFormacion'   => AmbienteFormacion::select('ambientes_formacion.id', 'ambientes_formacion.nombre', 'ambientes_formacion.facultad_id')->orderBy('ambientes_formacion.nombre', 'ASC')->join('facultades', 'ambientes_formacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->filterAmbienteFormacion(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [AmbienteFormacion::class, $institucionEducativa]);

        return Inertia::render('AmbientesFormacion/Create', [
            'institucionEducativa'              => $institucionEducativa,
            'facultades'                        => Facultad::select('id as value', 'nombre as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('nombre')->get(),
            'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AmbienteFormacionRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [AmbienteFormacion::class, $institucionEducativa]);

        $ambienteFormacion = new AmbienteFormacion();
        $ambienteFormacion->nombre              = $request->nombre;
        $ambienteFormacion->tipo                = $request->tipo;
        $ambienteFormacion->capacidad_aprox     = $request->capacidad_aprox;
        $ambienteFormacion->descripcion         = $request->descripcion;
        $ambienteFormacion->nombre_responsable  = $request->nombre_responsable;
        $ambienteFormacion->correo_responsable  = $request->correo_responsable;
        $ambienteFormacion->celular_responsable = $request->celular_responsable;

        if ($request->hasFile('foto')) {
            $file       = $request->file('foto');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($request->nombre, 0, 20)) . "-RREDSI-foto" . time() . $extension;
            Storage::putFileAs(
                'public/fotos-ambientes-formacion',
                $file,
                $fileName
            );

            $ambienteFormacion->foto  = "fotos-ambientes-formacion/$fileName";
        }

        // asociamos el ambiente de formacion con la facultad
        $ambienteFormacion->facultad()->associate($request->facultad_id);

        $ambienteFormacion->save();
        $ambienteFormacion->disciplinasSubareaConocimiento()->attach($request->disciplina_subarea_conocimiento_id);

        return redirect()->route('instituciones-educativas.ambientes-formacion.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AmbienteFormacion  $ambienteFormacion
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, AmbienteFormacion $ambienteFormacion)
    {
        $this->authorize('view', [AmbienteFormacion::class, $institucionEducativa, $ambienteFormacion]);

        $ambienteFormacion->facultad->institucionEducativa;
        $ambienteFormacion->disciplinasSubareaConocimiento;

        return Inertia::render('AmbientesFormacion/Show', [
            'institucionEducativa' => $institucionEducativa,
            'ambienteFormacion'    => $ambienteFormacion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AmbienteFormacion  $ambienteFormacion
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, AmbienteFormacion $ambienteFormacion)
    {
        $this->authorize('update', [AmbienteFormacion::class, $institucionEducativa, $ambienteFormacion]);

        return Inertia::render('AmbientesFormacion/Edit', [
            'institucionEducativa'              => $institucionEducativa,
            'facultades'                        => Facultad::select('id as value', 'nombre as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('nombre')->get(),
            'ambienteFormacion'                 => $ambienteFormacion,
            'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
            'disciplinasRelacionadas'           => $ambienteFormacion->disciplinasSubareaConocimiento()->select('disciplinas_subarea_conocimiento.id as value', 'disciplinas_subarea_conocimiento.nombre as label')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AmbienteFormacion  $ambienteFormacion
     * @return \Illuminate\Http\Response
     */
    public function update(AmbienteFormacionRequest $request, InstitucionEducativa $institucionEducativa, AmbienteFormacion $ambienteFormacion)
    {
        $this->authorize('update', [AmbienteFormacion::class, $institucionEducativa, $ambienteFormacion]);

        $ambienteFormacion->nombre              = $request->nombre;
        $ambienteFormacion->tipo                = $request->tipo;
        $ambienteFormacion->capacidad_aprox     = $request->capacidad_aprox;
        $ambienteFormacion->descripcion         = $request->descripcion;
        $ambienteFormacion->nombre_responsable  = $request->nombre_responsable;
        $ambienteFormacion->correo_responsable  = $request->correo_responsable;
        $ambienteFormacion->celular_responsable = $request->celular_responsable;

        if ($request->hasFile('foto')) {
            Storage::delete("public/$ambienteFormacion->foto");
            $file       = $request->file('foto');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($request->nombre, 0, 20)) . "-RREDSI-foto" . time() . $extension;
            Storage::putFileAs(
                'public/fotos-ambientes-formacion',
                $file,
                $fileName
            );

            $ambienteFormacion->foto  = "fotos-ambientes-formacion/$fileName";
        }

        // asociamos el ambiente de formacion con la facultad
        $ambienteFormacion->facultad()->associate($request->facultad_id);

        $ambienteFormacion->save();
        $ambienteFormacion->disciplinasSubareaConocimiento()->sync($request->disciplina_subarea_conocimiento_id);

        return redirect()->route('instituciones-educativas.ambientes-formacion.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AmbienteFormacion  $ambienteFormacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, AmbienteFormacion $ambienteFormacion)
    {
        $this->authorize('delete', [AmbienteFormacion::class, $institucionEducativa, $ambienteFormacion]);

        $ambienteFormacion->delete();

        return redirect()->route('instituciones-educativas.ambientes-formacion.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
