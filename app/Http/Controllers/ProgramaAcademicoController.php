<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramaAcademicoRequest;
use App\Models\ProgramaAcademico;
use App\Models\InstitucionEducativa;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramaAcademicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [ProgramaAcademico::class, $institucionEducativa]);

        return Inertia::render('ProgramasAcademicos/Index', [
            'institucionEducativa'  => $institucionEducativa,
            'programasAcademicos'   => ProgramaAcademico::select('programas_academicos.id', 'programas_academicos.nombre', 'programas_academicos.facultad_id')->orderBy('programas_academicos.nombre')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->filterProgramaAcademico(request()->only('search'))->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [ProgramaAcademico::class, $institucionEducativa]);

        return Inertia::render('ProgramasAcademicos/Create', [
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
    public function store(ProgramaAcademicoRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [ProgramaAcademico::class, $institucionEducativa]);

        $programaAcademico = new ProgramaAcademico();
        $programaAcademico->nombre              = $request->nombre;
        $programaAcademico->nivel_academico     = $request->nivel_academico;
        $programaAcademico->modalidad           = $request->modalidad;
        $programaAcademico->jornada             = $request->jornada;
        // asociacion de el programa academico con la facultad
        $programaAcademico->facultad()->associate($request->facultad_id);

        $programaAcademico->save();

        return redirect()->route('instituciones-educativas.programas-academicos.index', [$institucionEducativa])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProgramaAcademico  $programaAcademico
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, ProgramaAcademico $programaAcademico)
    {
        $this->authorize('view', [ProgramaAcademico::class, $institucionEducativa, $programaAcademico]);

        $programaAcademico->facultad;

        return Inertia::render('ProgramasAcademicos/Show', [
            'institucionEducativa'  => $institucionEducativa,
            'programaAcademico'     => $programaAcademico
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgramaAcademico  $programaAcademico
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, ProgramaAcademico $programaAcademico)
    {
        $this->authorize('update', [ProgramaAcademico::class, $institucionEducativa, $programaAcademico]);

        return Inertia::render('ProgramasAcademicos/Edit', [
            'institucionEducativa'  => $institucionEducativa,
            'programaAcademico'     => $programaAcademico,
            'facultades'            => $institucionEducativa->facultades()->select('id as value', 'nombre as label')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgramaAcademico  $programaAcademico
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramaAcademicoRequest $request, InstitucionEducativa $institucionEducativa, ProgramaAcademico $programaAcademico)
    {
        $this->authorize('update', [ProgramaAcademico::class, $institucionEducativa, $programaAcademico]);

        $programaAcademico->nombre              = $request->nombre;
        $programaAcademico->nivel_academico     = $request->nivel_academico;
        $programaAcademico->modalidad           = $request->modalidad;
        $programaAcademico->jornada             = $request->jornada;
        // asociacion de el programa academico con la facultad
        $programaAcademico->facultad()->associate($request->facultad_id);

        $programaAcademico->save();

        return redirect()->route('instituciones-educativas.programas-academicos.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgramaAcademico  $programaAcademico
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, ProgramaAcademico $programaAcademico)
    {
        $this->authorize('delete', [ProgramaAcademico::class, $institucionEducativa, $programaAcademico]);

        try {
            // validamos que el programa no este asociado a una graduacion si es a si no es posible eliminar el programa
            if (!is_null($programaAcademico->graduacion)) {
                return redirect()->route('instituciones-educativas.programas-academicos.index', [$institucionEducativa])->with('error', 'No es posible eliminar el programa académico porque está unido a la información de grado de varios estudiantes.');
            }

            $programaAcademico->delete();

            return redirect()->route('instituciones-educativas.programas-academicos.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
