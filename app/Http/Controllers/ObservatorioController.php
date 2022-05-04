<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Nodo;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProyectoRequest;
use App\Models\ProyectoEmpresa;

class ObservatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyectos = Proyecto::paginate(20);

        return view('Observatorio.index')->with('proyectos', $proyectos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Observatorio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProyectoRequest $request)
    {
        $proyecto = new Proyecto;
        $proyecto->titulo                   = $request->titulo;
        $proyecto->resumen                  = $request->resumen;
        $proyecto->instituciones_educativas = $request->instituciones_educativas;
        $proyecto->investigadores           = $request->investigadores;

        if ($proyecto->save()) {
            return redirect('proyectos')->with('message', 'El proyecto: ' . $proyecto->titulo . ' fue adicionado con exito');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $buscar
     * @return \Illuminate\Http\Response
     */
    public function result(Request $request, Nodo $nodo)
    {
        $search = $request->get('txt-search');
        if (!is_null($search)) {
            $proyectos = Proyecto::where('titulo', 'LIKE', '%' . $search . '%')->orwhere('resumen', 'LIKE', '%' . $search . '%')->orwhere('palabras_clave', 'LIKE', '%' . $search . '%')->orderby('titulo')->get();
        } else {
            $proyectos = [];
        }
        return view('Observatorio.resultados', compact('nodo', 'proyectos', 'search'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user            = auth()->user();
        $empresa         = $user->empresa()->first();
        $proyecto        = Proyecto::find($id);
        $proyectoEmpresa = null;

        if (ProyectoEmpresa::where('proyecto_empresa.proyecto_id', '=', $proyecto->id)->where('proyecto_empresa.empresa_id', '=', $empresa->id)->where('proyecto_empresa.activo', '=', true)->exists()) {
            $activo = true;
            $proyectoEmpresa = ProyectoEmpresa::where('proyecto_empresa.proyecto_id', '=', $proyecto->id)->where('proyecto_empresa.empresa_id', '=', $empresa->id)->where('proyecto_empresa.activo', '=', true)->first();
            $proyectoEmpresa = $proyectoEmpresa->id;
        } else {
            if (ProyectoEmpresa::where('proyecto_empresa.proyecto_id', '=', $proyecto->id)->where('proyecto_empresa.empresa_id', '=', $empresa->id)->where('proyecto_empresa.activo', '=', false)->exists()) {
                $activo = false;
                $proyectoEmpresa = ProyectoEmpresa::where('proyecto_empresa.proyecto_id', '=', $proyecto->id)->where('proyecto_empresa.empresa_id', '=', $empresa->id)->where('proyecto_empresa.activo', '=', false)->first();
                $proyectoEmpresa = $proyectoEmpresa->id;
            } else {
                $activo = false;
                $proyectoEmpresa = 'nulo';
            }
        }
        $grupoInvestigacion  = $proyecto->semillerosInvestigacion()->where('principal', 1)->first()->grupoInvestigacion;
        $facultad            = $grupoInvestigacion->facultad;

        if ($facultad) {
            $institucionEducativa = $facultad->institucionEducativa;
            $adminInstitucionEducativa =  $institucionEducativa->administrador;
        }
        return view('Observatorio.show', compact('proyecto', 'institucionEducativa', 'empresa', 'activo', 'proyectoEmpresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proyecto = Proyecto::findOrFail($id);

        return view('Observatorio.edit')->with('proyecto', $proyecto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proyecto = Proyecto::find($id);
        $proyecto->titulo                   = $request->titulo;
        $proyecto->resumen                  = $request->resumen;
        $proyecto->instituciones_educativas = $request->instituciones_educativas;
        $proyecto->investigadores           = $request->investigadores;

        if ($proyecto->save()) {
            return redirect('proyectos')->with('message', 'El proyecto: ' . $proyecto->titulo . ' fue modificado con exito');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);
        if ($proyecto->delete()) {
            return redirect('proyectos')->with('message', 'El proyecto: ' . $proyecto->titulo . 'fue eliminado con exito!');
        }
    }
}
