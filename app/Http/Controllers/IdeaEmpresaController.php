<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\IdeaEmpresa;
use App\Http\Requests\IdeaEmpresaRequest;
use App\Http\Controllers\NotificationController;
use App\Models\Empresa;
use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IdeaEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [IdeaEmpresa::class]);

        $user               = auth()->user();
        $empresaAuthUser    = $user->empresa()->first();

        return Inertia::render('IdeasEmpresa/Index', [
            'ideasEmpresa' => IdeaEmpresa::where('empresa_id', '=', $empresaAuthUser ? $empresaAuthUser->id : null)->filterIdeaEmpresa(request()->only('search'))->paginate()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [IdeaEmpresa::class]);

        return Inertia::render('IdeasEmpresa/Create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(IdeaEmpresaRequest $request)
    {
        $this->authorize('create', [IdeaEmpresa::class]);

        $user         = auth()->user();
        $user_empresa = $user->empresa()->first();

        if ($user_empresa) {
            $ideaEmpresa = new IdeaEmpresa();
            $ideaEmpresa->nombre         = $request->nombre;
            $ideaEmpresa->descripcion    = $request->descripcion;
            $ideaEmpresa->tipo           = $request->tipo;
            $ideaEmpresa->tiene_equipos  = $request->tiene_equipos;
            $ideaEmpresa->equipos        = $request->equipos;
            $ideaEmpresa->tiene_recursos = $request->tiene_recursos;
            $ideaEmpresa->recursos       = $request->recursos;
            $ideaEmpresa->condicion      = $request->condicion;
            $ideaEmpresa->es_publica     = $request->es_publica;

            $ideaEmpresa->empresa()->associate($user_empresa->id);

            if ($ideaEmpresa->save()) {
                // Crea un nuevo objeto de la clase Notification y ejecuta el método newBusinesIdea para crear la notificación de la idea
                $notification = new NotificationController;
                $notification->newEmpresaIdea($ideaEmpresa);

                return redirect()->route('ideas-empresa.index')->with('success', 'La idea fue creada correctamente');
            } else {
                return redirect()->route('ideas-empresa.create')->with('error', 'Hubo un error al momento de crear la idea');
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
    public function show(IdeaEmpresa $ideaEmpresa)
    {
        $this->authorize('view', [IdeaEmpresa::class, $ideaEmpresa]);

        $ideaEmpresa->empresa->user;

        $empresa = Empresa::where('id', '=', auth()->user()->empresa_id)->first();

        return Inertia::render('IdeasEmpresa/Show', [
            'ideaEmpresa'   => $ideaEmpresa,
            'respuestas'    => Respuesta::where('idea_empresa_id', '=', $ideaEmpresa->id)->get(),
            'respuesta'     => Respuesta::where('empresa_id', '=', $empresa->id)->where('idea_empresa_id', '=', $ideaEmpresa->id)->first()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(IdeaEmpresa $ideaEmpresa)
    {
        $this->authorize('update', [IdeaEmpresa::class, $ideaEmpresa]);

        return Inertia::render('IdeasEmpresa/Edit', [
            'ideaEmpresa' => $ideaEmpresa
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IdeaEmpresa  $product
     * @return \Illuminate\Http\Response
     */
    public function update(IdeaEmpresaRequest $request, IdeaEmpresa $ideaEmpresa)
    {
        $this->authorize('update', [IdeaEmpresa::class, $ideaEmpresa]);

        $ideaEmpresa->nombre         = $request->nombre;
        $ideaEmpresa->descripcion    = $request->descripcion;
        $ideaEmpresa->tipo           = $request->tipo;
        $ideaEmpresa->tiene_equipos  = $request->tiene_equipos;
        $ideaEmpresa->equipos        = $request->equipos;
        $ideaEmpresa->tiene_recursos = $request->tiene_recursos;
        $ideaEmpresa->recursos       = $request->recursos;
        $ideaEmpresa->condicion      = $request->condicion;
        $ideaEmpresa->es_publica     = $request->es_publica;

        if ($ideaEmpresa->save()) {
            return redirect()->back()->with('success', 'La idea fue editada correctamente');;
        } else {
            return redirect()->back()->with('error', 'Hubo un probema al guardar');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(IdeaEmpresa $ideaEmpresa)
    {
        $this->authorize('delete', [IdeaEmpresa::class, $ideaEmpresa]);

        $ideaEmpresa->delete();

        return redirect()->route('ideas-empresa.index')->with('success', 'La idea fue eliminada correctamente');
    }

    public function ideasRetos()
    {
        return Inertia::render('IdeasEmpresa/IdeasRetos', [
            'ideasEmpresa' => IdeaEmpresa::where('es_publica', true)->filterIdeaEmpresa(request()->only('search'))->paginate()
        ]);
    }
}
