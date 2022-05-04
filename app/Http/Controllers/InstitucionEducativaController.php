<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nodo;
use App\Models\InstitucionEducativa;

use App\Http\Requests\InstitucionEducativaRequest;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NotificacionGeneral;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class InstitucionEducativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [InstitucionEducativa::class]);

        return Inertia::render('InstitucionesEducativas/Index', [
            'institucionesEducativas' => InstitucionEducativa::orderBy('nombre')->filterInstitucionEducativa(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [InstitucionEducativa::class]);

        return Inertia::render('InstitucionesEducativas/Create', [
            'nodos'    => Nodo::select('id as value', 'departamento as label')->orderBy('departamento')->get(),
            'ciudades' => json_decode(Storage::get('public/json/municipios_caldas.json'), true)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstitucionEducativaRequest $request)
    {
        $this->authorize('create', [InstitucionEducativa::class]);

        $institucionEducativa = new InstitucionEducativa();
        $institucionEducativa->nombre           = $request->nombre;
        $institucionEducativa->nit              = $request->nit;
        $institucionEducativa->direccion        = $request->direccion;
        $institucionEducativa->ciudad           = $request->ciudad;
        $institucionEducativa->numero_telefono  = $request->numero_telefono;
        $institucionEducativa->sitio_web        = $request->sitio_web;

        if ($request->hasFile('logo')) {
            $file       = $request->file('logo');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$institucionEducativa->nombre-logo.$extension";
            Storage::putFileAs(
                'public/logos-instituciones-educativas',
                $file,
                $fileName
            );

            $institucionEducativa->logo  = "logos-instituciones-educativas/$fileName";
        }

        // asociamos la institucion con el nodo
        $institucionEducativa->nodo()->associate($request->nodo_id);
        // $institucionEducativa->administrador()->associate($request->administrador_id);

        if ($institucionEducativa->save()) {
            // asociamos el administrador a la institucion

            // $intitutions = $request->nodo_id->institucionesEducativas;
            // $users = [];

            // // se recorren las intituciones y se guardan los administradores
            // foreach ($intitutions as $intitution) {
            //     if (!is_null($intitution->administrador)) {
            //         array_push($users, $intitution->administrador);
            //     }
            // }

            // // le notificamos a los administradores de una nueva institucion creada
            // $tipo = 'institución educativa';
            // Notification::send($users, new NotificacionGeneral($institucionEducativa, $tipo));
        }

        return redirect()->route('instituciones-educativas.index', [$request->nodo_id])->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InstitucionEducativa  $institucionEducativa
     * @return \Illuminate\Http\Response
     */
    public function show(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('view', [InstitucionEducativa::class, $institucionEducativa]);

        $institucionEducativa->nodo;

        return Inertia::render('InstitucionesEducativas/Show', [
            'institucionEducativa' => $institucionEducativa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InstitucionEducativa  $institucionEducativa
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('update', [InstitucionEducativa::class, $institucionEducativa]);

        return Inertia::render('InstitucionesEducativas/Edit', [
            'institucionEducativa'  => $institucionEducativa,
            'nodos'                 => Nodo::select('id as value', 'departamento as label')->orderBy('departamento')->get(),
            'ciudades'              => json_decode(Storage::get('public/json/municipios_caldas.json'), true),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InstitucionEducativa  $institucionEducativa
     * @return \Illuminate\Http\Response
     */
    public function update(InstitucionEducativaRequest $request, InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('update', [InstitucionEducativa::class, $institucionEducativa]);

        $institucionEducativa->nombre           = $request->nombre;
        $institucionEducativa->nit              = $request->nit;
        $institucionEducativa->direccion        = $request->direccion;
        $institucionEducativa->ciudad           = $request->ciudad;
        $institucionEducativa->numero_telefono  = $request->numero_telefono;
        $institucionEducativa->sitio_web        = $request->sitio_web;

        if ($request->hasFile('logo')) {
            Storage::delete("public/logos-instituciones-educativas/$institucionEducativa->logo");

            $file       = $request->file('logo');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$institucionEducativa->nombre-logo.$extension";
            Storage::putFileAs(
                'public/logos-instituciones-educativas',
                $file,
                $fileName
            );

            $institucionEducativa->logo  = "logos-instituciones-educativas/$fileName";
        }

        $institucionEducativa->nodo()->associate($request->nodo_id);
        // $institucionEducativa->administrador()->associate($request->administrador_id);

        $institucionEducativa->save();

        return redirect()->route('instituciones-educativas.index')->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InstitucionEducativa  $institucionEducativa
     * @return \Illuminate\Http\Response
     */
    public function destroy(InstitucionEducativa $institucionEducativa)
    {
        $this->authorize('delete', [InstitucionEducativa::class, $institucionEducativa]);

        $institucionEducativa->delete();

        return redirect()->route('instituciones-educativas.index')->with('success', 'El recurso se ha eliminado correctamente.');
    }

    /**
     * Display a dashboard of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(InstitucionEducativa $institucionEducativa)
    {
        //
    }

    /**
     * Display BI.
     *
     * @return \Illuminate\Http\Response
     */
    public function bi(InstitucionEducativa $institucionEducativa)
    {
        $institucionEducativa->proyectosByAreaConocimiento   = $institucionEducativa->proyectosByAreaConocimiento();
        $institucionEducativa->proyectosByYear               = $institucionEducativa->proyectosByYear();
        $institucionEducativa->proyectosByTipoProyectos      = $institucionEducativa->proyectosByTipoProyectos();
        $institucionEducativa->eventosProyectos              = $institucionEducativa->eventosProyectos();
    }
}
