<?php

namespace App\Http\Controllers;

use App\Models\TipoProyecto;
use App\Models\InstitucionEducativa;
use App\Models\SemilleroInvestigacion;
use App\Models\Proyecto;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NotificacionGeneral;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\ProyectoRequest;
use App\Models\DisciplinaSubareaConocimiento;
use App\Models\Facultad;
use App\Models\LineaInvestigacion;
use App\Models\ProgramaAcademico;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('viewAny', [Proyecto::class, $institucionEducativa]);

        return Inertia::render('Proyectos/Index',  [
            'institucionEducativa'  => $institucionEducativa,
            'proyectos'             => Proyecto::select('proyectos.id', 'proyectos.titulo', 'proyectos.facultad_id', 'proyectos.privado')->orderBy('proyectos.titulo', 'ASC')->join('facultades', 'proyectos.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->with('autores')->filterProyecto(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [Proyecto::class, $institucionEducativa]);

        return Inertia::render('Proyectos/Create', [
            'institucionEducativa'              => $institucionEducativa,
            'tiposProyecto'                     => TipoProyecto::select('id as value', 'tipo as label')->orderBy('tipo')->get(),
            'semillerosInvestigacion'           => SemilleroInvestigacion::select('semilleros_investigacion.id as value', 'semilleros_investigacion.nombre as label')->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('semilleros_investigacion.nombre')->get(),
            'lineasInvestigacion'               => LineaInvestigacion::select('lineas_investigacion.id as value', 'lineas_investigacion.nombre as label')->join('grupos_investigacion', 'lineas_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('lineas_investigacion.nombre')->get(),
            'disciplinasSubareaConocimiento'    => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
            'programasAcademicos'               => ProgramaAcademico::select('programas_academicos.id as value', 'programas_academicos.nombre as label')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('programas_academicos.nombre')->get(),
            'facultades'                        => Facultad::select('id as value', 'nombre as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('nombre')->get(),
            'users'                             => User::select('id as value', 'name as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProyectoRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('create', [Proyecto::class, $institucionEducativa]);

        $authUser = auth()->user();

        $proyecto = new Proyecto();
        $proyecto->titulo                               = $request->titulo;
        $proyecto->fecha_inicio                         = $request->fecha_inicio;
        $proyecto->fecha_finalizacion                   = $request->fecha_finalizacion;
        $proyecto->resumen                              = $request->resumen;
        $proyecto->palabras_clave                       = $request->palabras_clave;
        $proyecto->descripcion_requerimiento_rol        = $request->descripcion_requerimiento_rol;
        $proyecto->requerimientos_equipos_descripcion   = $request->requerimientos_equipos_descripcion;
        $proyecto->requerimientos_roles                 = $request->requerimientos_roles;
        $proyecto->requerimientos_equipos               = $request->requerimientos_equipos;
        $proyecto->objetivo_general                     = $request->objetivo_general;
        $proyecto->privado                              = $request->privado;
        $proyecto->tipoProyecto()->associate($request->tipo_proyecto_id);
        $proyecto->facultad()->associate($request->facultad_id);

        $fechaFinalizacion = date('Y', strtotime($request->fecha_finalizacion));

        if ($request->hasFile('main_image')) {
            $file       = $request->file('main_image');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($proyecto->titulo, 0, 20)) . "-RREDSI-$fechaFinalizacion-main-image.$extension";
            Storage::putFileAs(
                'public/imagen-principal-proyectos',
                $file,
                $fileName
            );

            $proyecto->main_image  = "imagen-principal-proyectos/$fileName";
        }

        if ($request->hasFile('file')) {
            $file       = $request->file('file');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($proyecto->titulo, 0, 20)) . "-RREDSI-$fechaFinalizacion-file.$extension";
            Storage::putFileAs(
                'public/proyectos',
                $file,
                $fileName
            );

            $proyecto->file  = "proyectos/$fileName";
        }

        if ($proyecto->save()) {
            $proyecto->semillerosInvestigacion()->attach($request->semillero_investigacion_id);
            $proyecto->lineasInvestigacion()->attach($request->linea_investigacion_id);
            $proyecto->disciplinasSubareaConocimiento()->attach($request->disciplina_subarea_conocimiento_id);
            $proyecto->programasAcademicos()->attach($request->programa_academico_id);
            $proyecto->autores()->attach($authUser->id);
            $proyecto->autores()->attach($request->user_id);

            // Send notification student create semilleroInvestigacion
            // $facultadUser = $authUser->facultades()->where('principal', 1)->first();

            // if ($facultadUser) {
            //     $institucionEducativa = $facultadUser->institucionEducativa;
            //     $adminInstitucionEducativa       = $institucionEducativa->administrador;

            //     $type = 'proyecto';
            //     Notification::send($adminInstitucionEducativa, new NotificacionGeneral($proyecto, $type));
            // }
        }

        return redirect()->route('instituciones-educativas.proyectos.index', [$institucionEducativa->id])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa, Proyecto $proyecto)
    {
        $this->authorize('view', [Proyecto::class, $institucionEducativa, $proyecto]);

        $proyecto->facultad->institucionEducativa;
        $proyecto->disciplinasSubareaConocimiento;
        $proyecto->lineasInvestigacion;
        $proyecto->semillerosInvestigacion;
        $proyecto->programasAcademicos;
        $proyecto->tipoProyecto;
        $proyecto->facultad;
        $proyecto->autores;

        return Inertia::render('Proyectos/Show', [
            'institucionEducativa'  => $institucionEducativa,
            'proyecto'              => $proyecto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa, Proyecto $proyecto)
    {
        $this->authorize('update', [Proyecto::class, $institucionEducativa, $proyecto]);

        return Inertia::render('Proyectos/Edit', [
            'institucionEducativa'                  => $institucionEducativa,
            'proyecto'                              => $proyecto,
            'tiposProyecto'                         => TipoProyecto::select('id as value', 'tipo as label')->orderBy('tipo')->get(),
            'semillerosInvestigacion'               => SemilleroInvestigacion::select('semilleros_investigacion.id as value', 'semilleros_investigacion.nombre as label')->join('grupos_investigacion', 'semilleros_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('semilleros_investigacion.nombre')->get(),
            'lineasInvestigacion'                   => LineaInvestigacion::select('lineas_investigacion.id as value', 'lineas_investigacion.nombre as label')->join('grupos_investigacion', 'lineas_investigacion.grupo_investigacion_id', 'grupos_investigacion.id')->join('facultades', 'grupos_investigacion.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('lineas_investigacion.nombre')->get(),
            'disciplinasSubareaConocimiento'        => DisciplinaSubareaConocimiento::select('id as value', 'nombre as label', 'subarea_conocimiento_id')->orderBy('nombre')->get(),
            'programasAcademicos'                   => ProgramaAcademico::select('programas_academicos.id as value', 'programas_academicos.nombre as label')->join('facultades', 'programas_academicos.facultad_id', 'facultades.id')->where('facultades.institucion_educativa_id', $institucionEducativa->id)->orderBy('programas_academicos.nombre')->get(),
            'facultades'                            => Facultad::select('id as value', 'nombre as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('nombre')->get(),
            'programasAcademicosRelacionados'       => $proyecto->programasAcademicos()->select('programas_academicos.id as value', 'programas_academicos.nombre as label')->get(),
            'lineasInvestigacionRelacionadas'       => $proyecto->lineasInvestigacion()->select('lineas_investigacion.id as value', 'lineas_investigacion.nombre as label')->get(),
            'semillerosInvestigacionRelacionados'   => $proyecto->semillerosInvestigacion()->select('semilleros_investigacion.id as value', 'semilleros_investigacion.nombre as label')->get(),
            'disciplinasRelacionadas'               => $proyecto->disciplinasSubareaConocimiento()->select('disciplinas_subarea_conocimiento.id as value', 'disciplinas_subarea_conocimiento.nombre as label')->get(),
            'users'                                 => User::select('id as value', 'name as label')->where('institucion_educativa_id', $institucionEducativa->id)->orderBy('name')->get(),
            'usersRelacionados'                     => $proyecto->autores()->select('users.id as value', 'users.name as label')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(ProyectoRequest $request, InstitucionEducativa $institucionEducativa, Proyecto $proyecto)
    {
        $this->authorize('update', [Proyecto::class, $institucionEducativa, $proyecto]);

        $proyecto->titulo                               = $request->titulo;
        $proyecto->fecha_inicio                         = $request->fecha_inicio;
        $proyecto->fecha_finalizacion                   = $request->fecha_finalizacion;
        $proyecto->resumen                              = $request->resumen;
        $proyecto->palabras_clave                       = $request->palabras_clave;
        $proyecto->descripcion_requerimiento_rol        = $request->descripcion_requerimiento_rol;
        $proyecto->requerimientos_equipos_descripcion   = $request->requerimientos_equipos_descripcion;
        $proyecto->requerimientos_roles                 = $request->requerimientos_roles;
        $proyecto->requerimientos_equipos               = $request->requerimientos_equipos;
        $proyecto->objetivo_general                     = $request->objetivo_general;
        $proyecto->privado                              = $request->privado;
        $proyecto->tipoProyecto()->associate($request->tipo_proyecto_id);
        $proyecto->facultad()->associate($request->facultad_id);

        $fechaFinalizacion = date('Y', strtotime($proyecto->fecha_finalizacion));

        if ($request->hasFile('main_image')) {
            Storage::delete("public/$proyecto->main_image");
            $file       = $request->file('main_image');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($proyecto->titulo, 0, 20)) . "-RREDSI-$fechaFinalizacion-main-image.$extension";
            Storage::putFileAs(
                'public/imagen-principal-proyectos',
                $file,
                $fileName
            );

            $proyecto->main_image  = "imagen-principal-proyectos/$fileName";
        }

        if ($request->hasFile('file')) {
            Storage::delete("public/$proyecto->file");
            $file       = $request->file('file');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($proyecto->titulo, 0, 20)) . "-RREDSI-$fechaFinalizacion-file.$extension";
            Storage::putFileAs(
                'public/proyectos',
                $file,
                $fileName
            );

            $proyecto->file  = "proyectos/$fileName";
        }

        if ($proyecto->save()) {
            $proyecto->semillerosInvestigacion()->sync($request->semillero_investigacion_id);
            $proyecto->lineasInvestigacion()->sync($request->linea_investigacion_id);
            $proyecto->disciplinasSubareaConocimiento()->sync($request->disciplina_subarea_conocimiento_id);
            $proyecto->programasAcademicos()->sync($request->programa_academico_id);
            $proyecto->autores()->sync($request->user_id);
        }

        return redirect()->route('instituciones-educativas.proyectos.index', [$institucionEducativa])->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa, Proyecto $proyecto)
    {
        $this->authorize('delete', [Proyecto::class, $institucionEducativa, $proyecto]);

        if ($proyecto->eventos()->count() > 0) {
            return redirect()->back()->with('estado', 'El proyecto no se puede eliminar porque está registrado a uno o varios eventos.');
        }

        $proyecto->delete();

        return redirect()->route('instituciones-educativas.proyectos.index', [$institucionEducativa])->with('success', 'El recurso se ha eliminado correctamente.');
    }
}
