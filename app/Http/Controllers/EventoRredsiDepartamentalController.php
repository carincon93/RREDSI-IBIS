<?php

namespace App\Http\Controllers;

use App\Models\EventoRredsiDepartamental;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventoRredsiDepartamentalRequest;
use App\Http\Requests\ProyectoEventoRredsiDepartamentalRequest;
use App\Models\Nodo;
use App\Models\ProgramaAcademico;
use App\Models\ProyectoEventoRredsiDepartamental;
use App\Models\SemilleroInvestigacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EventoRredsiDepartamentalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Nodo $nodo)
    {
        return Inertia::render('EventosRredsiDepartamental/Index', [
            'filters'                       => request()->all('search'),
            'nodo'                          => $nodo,
            'eventosRredsiDepartamental'    => EventoRredsiDepartamental::orderBy('titulo', 'ASC')->filterEventoRredsiDepartamental(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Nodo $nodo)
    {
        return Inertia::render('EventosRredsiDepartamental/Create', [
            'nodo' => $nodo,
            'institucionesEducativas' => $nodo->institucionesEducativas()->select('id as value', 'nombre as label')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventoRredsiDepartamentalRequest $request, Nodo $nodo)
    {
        $year = date('Y', strtotime($request->fecha_finalizacion));

        if ($request->estado) {
            DB::table('eventos_rredsi_departamental')->update(['estado' => false]);
        }

        $eventoRredsiDepartamental = new EventoRredsiDepartamental();
        $eventoRredsiDepartamental->titulo              = $request->titulo;
        $eventoRredsiDepartamental->fecha_inicio        = $request->fecha_inicio;
        $eventoRredsiDepartamental->fecha_finalizacion  = $request->fecha_finalizacion;
        $eventoRredsiDepartamental->objetivos           = $request->objetivos;
        $eventoRredsiDepartamental->cronograma          = $request->cronograma;
        $eventoRredsiDepartamental->areas_conocimiento  = $request->areas_conocimiento;
        $eventoRredsiDepartamental->estado              = $request->estado;

        if ($request->hasFile('afiche')) {
            $file       = $request->file('afiche');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-afiche-$year.$extension";
            Storage::putFileAs(
                'public/afiches',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->afiche  = "afiches/$fileName";
        }

        if ($request->hasFile('formato_guia_ponencia')) {
            $file       = $request->file('formato_guia_ponencia');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-formato_guia_ponencia-$year.$extension";
            Storage::putFileAs(
                'public/formatos-guia-ponencias',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->formato_guia_ponencia  = "formatos-guia-ponencias/$fileName";
        }

        if ($request->hasFile('carta_aval_ponencia')) {
            $file       = $request->file('carta_aval_ponencia');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-carta_aval_ponencia-$year.$extension";
            Storage::putFileAs(
                'public/cartas-aval-ponencias',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->carta_aval_ponencia  = "cartas-aval-ponencias/$fileName";
        }

        if ($request->hasFile('plantilla_presentacion_ponencia')) {
            $file       = $request->file('plantilla_presentacion_ponencia');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-plantilla_presentacion_ponencia-$year.$extension";
            Storage::putFileAs(
                'public/plantillas-presentacion-ponencias',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->plantilla_presentacion_ponencia  = "plantillas-presentacion-ponencias/$fileName";
        }

        if ($request->hasFile('guia_proyecto_finalizado')) {
            $file       = $request->file('guia_proyecto_finalizado');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-guia_proyecto_finalizado-$year.$extension";
            Storage::putFileAs(
                'public/guias-proyecto-finalizado',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->guia_proyecto_finalizado  = "guias-proyecto-finalizado/$fileName";
        }

        if ($request->hasFile('formato_guia_poster')) {
            $file       = $request->file('formato_guia_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-formato_guia_poster-$year.$extension";
            Storage::putFileAs(
                'public/formatos-guia-posters',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->formato_guia_poster  = "formatos-guia-posters/$fileName";
        }

        if ($request->hasFile('carta_aval_poster')) {
            $file       = $request->file('carta_aval_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-carta_aval_poster-$year.$extension";
            Storage::putFileAs(
                'public/cartas-aval-posters',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->carta_aval_poster  = "cartas-aval-posters/$fileName";
        }

        if ($request->hasFile('plantilla_presentacion_poster')) {
            $file       = $request->file('plantilla_presentacion_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-plantilla_presentacion_poster-$year.$extension";
            Storage::putFileAs(
                'public/plantillas-presentacion-posters',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->plantilla_presentacion_poster  = "plantillas-presentacion-posters/$fileName";
        }

        $eventoRredsiDepartamental->introduccion = $request->introduccion;

        $eventoRredsiDepartamental->nodo()->associate($nodo);
        $eventoRredsiDepartamental->institucionEducativa()->associate($request->institucion_educativa_id);

        $eventoRredsiDepartamental->save();

        return redirect()->route('nodos.show', $nodo)->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventoRredsiDepartamental  $eventoRredsiDepartamental
     * @return \Illuminate\Http\Response
     */
    public function show(Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {
        $eventoRredsiDepartamental->institucionEducativa;

        return Inertia::render('EventosRredsiDepartamental/Show', [
            'nodo' => $nodo,
            'eventoRredsiDepartamental' => $eventoRredsiDepartamental
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventoRredsiDepartamental  $eventoRredsiDepartamental
     * @return \Illuminate\Http\Response
     */
    public function edit(Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {
        return Inertia::render('EventosRredsiDepartamental/Edit', [
            'nodo' => $nodo,
            'eventoRredsiDepartamental' => $eventoRredsiDepartamental,
            'institucionesEducativas'   => $nodo->institucionesEducativas()->select('id as value', 'nombre as label')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EventoRredsiDepartamental  $eventoRredsiDepartamental
     * @return \Illuminate\Http\Response
     */
    public function update(EventoRredsiDepartamentalRequest $request, Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {
        $year = date('Y', strtotime($request->fecha_finalizacion));

        if ($request->estado == true) {
            DB::table('eventos_rredsi_departamental')->whereNotIn('id', [$eventoRredsiDepartamental->id])->update(['estado' => false]);
        }

        $eventoRredsiDepartamental->titulo              = $request->titulo;
        $eventoRredsiDepartamental->fecha_inicio        = $request->fecha_inicio;
        $eventoRredsiDepartamental->fecha_finalizacion  = $request->fecha_finalizacion;
        $eventoRredsiDepartamental->objetivos           = $request->objetivos;
        $eventoRredsiDepartamental->cronograma          = $request->cronograma;
        $eventoRredsiDepartamental->areas_conocimiento  = $request->areas_conocimiento;
        $eventoRredsiDepartamental->estado              = $request->estado;

        if ($request->hasFile('afiche')) {
            Storage::delete("public/$eventoRredsiDepartamental->afiche");

            $file       = $request->file('afiche');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-afiche-$year.$extension";
            Storage::putFileAs(
                'public/afiches',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->afiche  = "afiches/$fileName";
        }

        if ($request->hasFile('formato_guia_ponencia')) {
            Storage::delete("public/$eventoRredsiDepartamental->formato_guia_ponencia");

            $file       = $request->file('formato_guia_ponencia');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-formato_guia_ponencia-$year.$extension";
            Storage::putFileAs(
                'public/formatos-guia-ponencias',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->formato_guia_ponencia  = "formatos-guia-ponencias/$fileName";
        }

        if ($request->hasFile('carta_aval_ponencia')) {
            Storage::delete("public/$eventoRredsiDepartamental->formato_guia_ponencia");

            $file       = $request->file('carta_aval_ponencia');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-carta_aval_ponencia-$year.$extension";
            Storage::putFileAs(
                'public/cartas-aval-ponencias',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->carta_aval_ponencia  = "cartas-aval-ponencias/$fileName";
        }

        if ($request->hasFile('plantilla_presentacion_ponencia')) {
            Storage::delete("public/$eventoRredsiDepartamental->formato_guia_ponencia");

            $file       = $request->file('plantilla_presentacion_ponencia');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-plantilla_presentacion_ponencia-$year.$extension";
            Storage::putFileAs(
                'public/plantillas-presentacion-ponencias',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->plantilla_presentacion_ponencia  = "plantillas-presentacion-ponencias/$fileName";
        }

        if ($request->hasFile('guia_proyecto_finalizado')) {
            Storage::delete("public/$eventoRredsiDepartamental->formato_guia_ponencia");

            $file       = $request->file('guia_proyecto_finalizado');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-guia_proyecto_finalizado-$year.$extension";
            Storage::putFileAs(
                'public/guias-proyecto-finalizado',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->guia_proyecto_finalizado  = "guias-proyecto-finalizado/$fileName";
        }

        if ($request->hasFile('formato_guia_poster')) {
            Storage::delete("public/$eventoRredsiDepartamental->formato_guia_poster");

            $file       = $request->file('formato_guia_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-formato_guia_poster-$year.$extension";
            Storage::putFileAs(
                'public/formatos-guia-posters',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->formato_guia_poster  = "formatos-guia-posters/$fileName";
        }

        if ($request->hasFile('carta_aval_poster')) {
            Storage::delete("public/$eventoRredsiDepartamental->formato_guia_poster");

            $file       = $request->file('carta_aval_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-carta_aval_poster-$year.$extension";
            Storage::putFileAs(
                'public/cartas-aval-posters',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->carta_aval_poster  = "cartas-aval-posters/$fileName";
        }

        if ($request->hasFile('plantilla_presentacion_poster')) {
            Storage::delete("public/$eventoRredsiDepartamental->formato_guia_poster");

            $file       = $request->file('plantilla_presentacion_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-plantilla_presentacion_poster-$year.$extension";
            Storage::putFileAs(
                'public/plantillas-presentacion-posters',
                $file,
                $fileName
            );

            $eventoRredsiDepartamental->plantilla_presentacion_poster  = "plantillas-presentacion-posters/$fileName";
        }

        $eventoRredsiDepartamental->introduccion = $request->introduccion;

        $eventoRredsiDepartamental->nodo()->associate($nodo);
        $eventoRredsiDepartamental->institucionEducativa()->associate($request->institucion_educativa_id);

        $eventoRredsiDepartamental->save();

        return redirect()->back()->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventoRredsiDepartamental  $eventoRredsiDepartamental
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {
        $eventoRredsiDepartamental->delete();

        return redirect()->route('nodos.show', $nodo)->with('success', 'El recurso se ha eliminado correctamente.');
    }

    public function showRegistro(Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {
        $areas = array();

        foreach (json_decode($eventoRredsiDepartamental->areas_conocimiento) as $area) {
            array_push($areas, ['value' => $area->value, 'label' => $area->value]);
        }

        return Inertia::render('Explorer/Eventos/RegistroEventoDepartamental', [
            'nodo'                      => $nodo,
            'eventoRredsiDepartamental' => $eventoRredsiDepartamental,
            'estudiantes'               => User::select('users.id as value', 'users.name as label')->join('instituciones_educativas', 'users.institucion_educativa_id', 'instituciones_educativas.id')->where('instituciones_educativas.nodo_id', $nodo->id)->orderBy('name')->get(),
            'programasAcademicos'       => ProgramaAcademico::select('programas_academicos.id as value', 'programas_academicos.nombre as label')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->join('instituciones_educativas', 'facultades.institucion_educativa_id', 'instituciones_educativas.id')->where('instituciones_educativas.nodo_id', $nodo->id)->orderBy('programas_academicos.nombre')->get(),
            'semillerosInvestigacion'   => SemilleroInvestigacion::select('semilleros_investigacion.id as value', 'semilleros_investigacion.nombre as label')->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->join('instituciones_educativas', 'facultades.institucion_educativa_id', 'instituciones_educativas.id')->where('instituciones_educativas.nodo_id', $nodo->id)->orderBy('semilleros_investigacion.nombre')->get(),
            'areasConocimiento'         => $areas
        ]);
    }

    public function registrarse(ProyectoEventoRredsiDepartamentalRequest $request, Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {

        $year = date('Y', strtotime($eventoRredsiDepartamental->fecha_finalizacion));

        $proyectoEventoDepartamental = new ProyectoEventoRredsiDepartamental();

        $proyectoEventoDepartamental->tipo_presentacion  = $request->tipo_presentacion;
        $proyectoEventoDepartamental->modalidad_proyecto = $request->modalidad_proyecto;

        if ($request->hasFile('carta_aval')) {
            $file       = $request->file('carta_aval');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-evento-carta-aval-tutor-$year.$extension";
            Storage::putFileAs(
                'public/evento-cartas-aval-tutor',
                $file,
                $fileName
            );

            $proyectoEventoDepartamental->carta_aval = "evento-cartas-aval-tutor/$fileName";
        }

        if ($request->hasFile('carta_poster')) {
            $file       = $request->file('carta_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-evento-carta-poster-$year.$extension";
            Storage::putFileAs(
                'public/evento-cartas-poster',
                $file,
                $fileName
            );

            $proyectoEventoDepartamental->carta_poster = "evento-cartas-poster/$fileName";
        }

        if ($request->hasFile('documento_proyecto_finalizado')) {
            $file       = $request->file('documento_proyecto_finalizado');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-evento-documento-proyecto-$year.$extension";
            Storage::putFileAs(
                'public/evento-documentos-proyecto',
                $file,
                $fileName
            );

            $proyectoEventoDepartamental->documento_proyecto_finalizado = "evento-documentos-proyecto/$fileName";
        }

        $proyectoEventoDepartamental->autorizacion_memorias          = $request->autorizacion_memorias;
        $proyectoEventoDepartamental->autorizacion_tratamiento_datos = $request->autorizacion_tratamiento_datos;
        $proyectoEventoDepartamental->area_conocimiento              = $request->area_conocimiento;

        $proyectoEventoDepartamental->eventoRredsiDepartamental()->associate($eventoRredsiDepartamental);
        $proyectoEventoDepartamental->primerPonente()->associate($request->primer_ponente_id);
        $proyectoEventoDepartamental->segundoPonente()->associate($request->segundo_ponente_id);
        $proyectoEventoDepartamental->programaAcademicoPrimerPonente()->associate($request->programa_academico_primer_ponente_id);
        $proyectoEventoDepartamental->programaAcademicoSegundoPonente()->associate($request->programa_academico_segundo_ponente_id);
        $proyectoEventoDepartamental->semilleroInvestigacion()->associate($request->semillero_investigacion_id);

        $proyectoEventoDepartamental->save();

        return back()->with('success', 'Se ha registrado al evento correctamente.');
    }

    public function inscritos(Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental)
    {
        return Inertia::render('EventosRredsiDepartamental/Inscritos', [
            'nodo'                      => $nodo,
            'eventoRredsiDepartamental' => $eventoRredsiDepartamental,
            'inscritos'                 => $eventoRredsiDepartamental->proyectosEventoRredsiDepartamental()->with('primerPonente', 'segundoPonente', 'semilleroInvestigacion.grupoInvestigacion.facultad.institucionEducativa')->paginate(15)
        ]);
    }

    public function detallesInscrito(Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental, $inscritoId)
    {
        $proyectoEventoDepartamental = ProyectoEventoRredsiDepartamental::find($inscritoId);

        $proyectoEventoDepartamental->primerPonente;
        $proyectoEventoDepartamental->segundoPonente;

        $proyectoEventoDepartamental->programaAcademicoPrimerPonente;
        $proyectoEventoDepartamental->programaAcademicoSegundoPonente;

        $proyectoEventoDepartamental->load('semilleroInvestigacion.grupoInvestigacion.facultad.institucionEducativa');

        return Inertia::render('EventosRredsiDepartamental/DetallesInscrito', [
            'nodo'                      => $nodo,
            'eventoRredsiDepartamental' => $eventoRredsiDepartamental,
            'inscrito'                  => $proyectoEventoDepartamental
        ]);
    }

    public function editarInscrito(Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental, $inscritoId)
    {
        $proyectoEventoDepartamental = ProyectoEventoRredsiDepartamental::find($inscritoId);

        $areas = array();

        foreach (json_decode($eventoRredsiDepartamental->areas_conocimiento) as $area) {
            array_push($areas, ['value' => $area->value, 'label' => $area->value]);
        }

        return Inertia::render('EventosRredsiDepartamental/EditInscrito', [
            'nodo'                          => $nodo,
            'eventoRredsiDepartamental'     => $eventoRredsiDepartamental,
            'estudiantes'                   => User::select('users.id as value', 'users.name as label')->join('instituciones_educativas', 'users.institucion_educativa_id', 'instituciones_educativas.id')->where('instituciones_educativas.nodo_id', $nodo->id)->orderBy('name')->get(),
            'programasAcademicos'           => ProgramaAcademico::select('programas_academicos.id as value', 'programas_academicos.nombre as label')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->join('instituciones_educativas', 'facultades.institucion_educativa_id', 'instituciones_educativas.id')->where('instituciones_educativas.nodo_id', $nodo->id)->orderBy('programas_academicos.nombre')->get(),
            'semillerosInvestigacion'       => SemilleroInvestigacion::select('semilleros_investigacion.id as value', 'semilleros_investigacion.nombre as label')->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->join('instituciones_educativas', 'facultades.institucion_educativa_id', 'instituciones_educativas.id')->where('instituciones_educativas.nodo_id', $nodo->id)->orderBy('semilleros_investigacion.nombre')->get(),
            'areasConocimiento'             => $areas,
            'proyectoEventoDepartamental'   => $proyectoEventoDepartamental
        ]);
    }

    public function updateInscrito(ProyectoEventoRredsiDepartamentalRequest $request, Nodo $nodo, EventoRredsiDepartamental $eventoRredsiDepartamental, $inscritoId)
    {
        $proyectoEventoDepartamental = ProyectoEventoRredsiDepartamental::find($inscritoId);

        $year = date('Y', strtotime($eventoRredsiDepartamental->fecha_finalizacion));

        $proyectoEventoDepartamental->tipo_presentacion  = $request->tipo_presentacion;
        $proyectoEventoDepartamental->modalidad_proyecto = $request->modalidad_proyecto;

        if ($request->hasFile('carta_aval')) {
            Storage::delete("public/$proyectoEventoDepartamental->carta_aval");

            $file       = $request->file('carta_aval');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-evento-carta-aval-tutor-$year.$extension";
            Storage::putFileAs(
                'public/evento-cartas-aval-tutor',
                $file,
                $fileName
            );

            $proyectoEventoDepartamental->carta_aval = "evento-cartas-aval-tutor/$fileName";
        }

        if ($request->hasFile('carta_poster')) {
            Storage::delete("public/$proyectoEventoDepartamental->carta_poster");

            $file       = $request->file('carta_poster');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-evento-carta-poster-$year.$extension";
            Storage::putFileAs(
                'public/evento-cartas-poster',
                $file,
                $fileName
            );

            $proyectoEventoDepartamental->carta_poster = "evento-cartas-poster/$fileName";
        }

        if ($request->hasFile('documento_proyecto_finalizado')) {
            Storage::delete("public/$proyectoEventoDepartamental->documento_proyecto_finalizado");

            $file       = $request->file('documento_proyecto_finalizado');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-evento-documento-proyecto-$year.$extension";
            Storage::putFileAs(
                'public/evento-documentos-proyecto',
                $file,
                $fileName
            );

            $proyectoEventoDepartamental->documento_proyecto_finalizado = "evento-documentos-proyecto/$fileName";
        }

        $proyectoEventoDepartamental->autorizacion_memorias          = $request->autorizacion_memorias;
        $proyectoEventoDepartamental->autorizacion_tratamiento_datos = $request->autorizacion_tratamiento_datos;
        $proyectoEventoDepartamental->area_conocimiento              = $request->area_conocimiento;

        $proyectoEventoDepartamental->eventoRredsiDepartamental()->associate($eventoRredsiDepartamental);
        $proyectoEventoDepartamental->primerPonente()->associate($request->primer_ponente_id);
        $proyectoEventoDepartamental->segundoPonente()->associate($request->segundo_ponente_id);
        $proyectoEventoDepartamental->programaAcademicoPrimerPonente()->associate($request->programa_academico_primer_ponente_id);
        $proyectoEventoDepartamental->programaAcademicoSegundoPonente()->associate($request->programa_academico_segundo_ponente_id);
        $proyectoEventoDepartamental->semilleroInvestigacion()->associate($request->semillero_investigacion_id);

        $proyectoEventoDepartamental->save();

        return back()->with('success', 'Se ha modificado la información correctamente.');
    }
}
