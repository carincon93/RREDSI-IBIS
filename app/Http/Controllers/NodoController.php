<?php

namespace App\Http\Controllers;

use App\Models\Nodo;
use App\Http\Requests\NodoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class NodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [Nodo::class]);

        return Inertia::render('Nodos/Index', [
            'nodos' => Nodo::orderBy('departamento')->filterNodo(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [Nodo::class]);

        return Inertia::render('Nodos/Create', [
            'departamentos' => json_decode(Storage::get('public/json/departamentos.json'), true),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NodoRequest $request)
    {
        $this->authorize('create', [Nodo::class]);

        $nodo = new Nodo();
        $nodo->departamento = $request->departamento;

        if ($request->hasFile('logo')) {
            $file       = $request->file('logo');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-logo.$extension";
            Storage::putFileAs(
                'public/logos',
                $file,
                $fileName
            );

            $nodo->logo  = "logos/$fileName";
        }
        // $nodo->administrador()->associate($request->administrador_id);

        $nodo->save();

        return redirect()->route('nodos.index')->with('success', 'El recurso se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nodo  $nodo
     * @return \Illuminate\Http\Response
     */
    public function show(Nodo $nodo)
    {
        $this->authorize('view', [Nodo::class, $nodo]);

        $nodo->institucionesEducativas;

        $nodo->load('eventosRredsiDepartamental.institucionEducativa');

        return Inertia::render('Nodos/Show', [
            'nodo' => $nodo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nodo  $nodo
     * @return \Illuminate\Http\Response
     */
    public function edit(Nodo $nodo)
    {
        $this->authorize('update', [Nodo::class, $nodo]);

        return Inertia::render('Nodos/Edit', [
            'nodo'          => $nodo,
            'departamentos' => json_decode(Storage::get('public/json/departamentos.json'), true),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nodo  $nodo
     * @return \Illuminate\Http\Response
     */
    public function update(NodoRequest $request, Nodo $nodo)
    {
        $this->authorize('update', [Nodo::class, $nodo]);

        $nodo->departamento = $request->departamento;

        if ($request->hasFile('logo')) {
            Storage::delete("public/$nodo->logo");
            $file       = $request->file('logo');
            $extension  = $file->extension();
            $fileName   = "RREDSI-$nodo->departamento-logo.$extension";
            Storage::putFileAs(
                'public/logos',
                $file,
                $fileName
            );

            $nodo->logo = "logos/$fileName";
        }
        // $nodo->administrador()->associate($request->administrador_id);

        $nodo->save();

        return redirect()->route('nodos.index')->with('success', 'El recurso se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nodo  $nodo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nodo $nodo)
    {
        $this->authorize('delete', [Nodo::class, $nodo]);

        //

        return redirect()->route('nodos.index')->with('success', 'No se puede eliminar el nodo.');
    }
}
