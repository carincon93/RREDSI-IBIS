<?php

namespace App\Http\Controllers;

use App\Models\InformacionLegal;
use App\Http\Requests\InformacionLegalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformacionLegalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $informacionLegal = InformacionLegal::orderBy('titulo')->get();

        return view('InformacionLegal.index', compact('informacionLegal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('InformacionLegal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InformacionLegalRequest $request)
    {


        $informacionLegal               = new InformacionLegal();
        $informacionLegal->titulo       = $request->get('titulo');
        $informacionLegal->slug         = Str::slug($request->get('titulo'));
        $informacionLegal->descripcion  = $request->get('descripcion');

        if ($informacionLegal->save()) {
            $message = 'Your store processed correctly';
        }

        return redirect()->route('informacion-legal.index')->with('estado', $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\informacion_legal  $informacion_legal
     * @return \Illuminate\Http\Response
     */
    public function show(InformacionLegal $informacionLegal)
    {


        return view('InformacionLegal.show', compact('InformacionLegal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\informacion_legal  $informacion_legal
     * @return \Illuminate\Http\Response
     */
    public function edit(InformacionLegal $informacionLegal)
    {


        return view('InformacionLegal.edit', compact('InformacionLegal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\informacion_legal  $informacion_legal
     * @return \Illuminate\Http\Response
     */
    public function update(InformacionLegalRequest $request, InformacionLegal $informacionLegal)
    {


        $informacionLegal->titulo       = $request->get('titulo');
        $informacionLegal->slug         = Str::slug($request->get('titulo'));
        $informacionLegal->descripcion  = $request->get('descripcion');

        if ($informacionLegal->save()) {
            $message = 'Your update processed correctly';
        }

        return redirect()->route('informacion-legal.index')->with('estado', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\informacion_legal  $informacion_legal
     * @return \Illuminate\Http\Response
     */
    public function destroy(InformacionLegal $informacionLegal)
    {


        if ($informacionLegal->delete()) {
            $message = 'Your delete processed correctly';
        }
        return redirect()->route('informacion-legal.index')->with('estado', $message);
    }

    /**
     * showInformacionLegal
     *
     * @return void
     */
    public function showInformacionLegal($slug)
    {
        $informacionLegalData = InformacionLegal::where('slug', Str::slug($slug))->firstOrFail();
        $informacionLegal = InformacionLegal::orderBy('titulo')->get();

        return view('Explorer.mostrar-informacion-legal', compact('informacionLegalData', 'informacionLegal'));
    }
}
