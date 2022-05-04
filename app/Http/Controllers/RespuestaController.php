<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use App\Http\Controllers\Controller;
use App\Http\Requests\RespuestaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RespuestaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RespuestaRequest $request)
    {
        if (auth()->user()->empresa()->first()) {
            $file = $request->documento;

            if ($request->hasFile('documento')) {
                $file = $request->file('documento')->store('respuestas-documentos', 'public');
            }

            Respuesta::updateOrCreate(
                ['idea_empresa_id' => $request->idea_empresa_id, 'empresa_id' => auth()->user()->empresa()->first()->id],
                [
                    'titulo'      => $request->titulo,
                    'descripcion' => $request->descripcion,
                    'documento'   => $file
                ]
            );

            return redirect()->back()->with('success', 'Respuesta creada correctamente');
        } else {
            return redirect()->back()->with('error', 'No está asociado a ninguna empresa. Por favor comuníquese con el administrador del sistema.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Respuesta  $respuesta
     * @return \Illuminate\Http\Response
     */
    public function update(RespuestaRequest $request, Respuesta $respuesta)
    {
        $respuesta->titulo        =   $request->titulo;
        $respuesta->descripcion   =   $request->descripcion;

        $file = $request->documento;

        if ($request->hasFile('documento')) {
            Storage::delete("public/$respuesta->documento");
            $file = $request->file('documento')->store('respuestas-documentos', 'public');
            $respuesta->documento = $file;
        }
        if ($respuesta->save()) {
            return redirect()->back()->with('estado', 'Respuesta actualizada correctamente');
        } else {
            return redirect()->back()->with('estado', 'Hubo un error al actualizar la respuesta');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Respuesta  $respuesta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Respuesta $respuesta)
    {
        //
    }
}
