<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoEmpresa;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProyectoEmpresaRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProyectoEmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user     = auth()->user();
        $empresa  = $user->empresa()->first();

        $proyectos = Proyecto::select('proyectos.*', 'proyecto_empresa.activo')
            ->join('proyecto_empresa', 'proyectos.id', 'proyecto_empresa.proyecto_id')
            ->where('proyecto_empresa.activo', '=', true)
            ->where('proyecto_empresa.empresa_id', $empresa ? $empresa->id : null)
            ->with('facultad.institucionEducativa')
            ->filterProyecto(request()->only('search'))->paginate();

        return Inertia::render('DashboardEmpresa/MisIntereses', [
            'proyectos' => $proyectos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = auth()->user()->empresa()->first();

        if (auth()->user()->empresa()->first()) {
            $proyectoEmpresa = ProyectoEmpresa::where('empresa_id', $empresa->id)->where('proyecto_id', $request->proyecto_id)->first();
            if (!$proyectoEmpresa) {
                ProyectoEmpresa::create(
                    [
                        'empresa_id'    => $empresa->id,
                        'proyecto_id'   => $request->proyecto_id,
                        'activo' => true,
                    ]
                );

                $estado = 'Se ha generado la alerta de interés';
            } else {
                $proyectoEmpresa->delete();

                $estado = 'Se ha removido la alerta de interés';
            }
            return back()->with('success', $estado);
        } else {
            return redirect()->back()->with('error', 'No está asociado a ninguna empresa. Por favor comuníquese con el administrador del sistema.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProyectoEmpresa  $proyectoEmpresa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proyectoEmpresa    = ProyectoEmpresa::findOrFail($id);
        $proyecto           = Proyecto::where('proyectos.id', '=', $proyectoEmpresa->proyecto_id)->first();

        return view('ProyectoEmpresa.show', compact('proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProyectoEmpresa  $proyectoEmpresa
     * @return \Illuminate\Http\Response
     */
    public function edit(ProyectoEmpresa $proyectoEmpresa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ProyectoEmpresaRequest $request, $id)
    {
        $proyectoEmpresa            = ProyectoEmpresa::find($id);
        $proyectoEmpresa->activo    = $request->activo;

        if (!$proyectoEmpresa->save()) {
            return 'Ha ocurrido un error. Porfavor intenta de nuevo mas tarde.';
        } else {
            if ($proyectoEmpresa->activo == 'true') {
                return 'Has generado el interes';
            } else {
                return 'Ya desmarcaste el interes';
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProyectoEmpresa  $proyectoEmpresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProyectoEmpresa $proyectoEmpresa)
    {
        //
    }
}
