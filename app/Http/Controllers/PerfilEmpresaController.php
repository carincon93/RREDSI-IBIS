<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Models\Empresa;
use App\Models\User;

class PerfilEmpresaController extends Controller
{
    public function index()
    {
        $user    = auth()->user();
        $empresa = $user->empresa()->first();

        return view('PerfilEmpresa.index', compact('user', 'empresa'));
    }

    public function edit(User $user)
    {
        $user = auth()->user();
        $user->empresa()->get();
        $empresa    = $user->empresa()->first();
        return view('PerfilEmpresa.edit', compact('user', 'empresa'));
    }

    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        $empresa->nombre                = $request->get('nombre');
        $empresa->nit                   = $request->get('nit');
        $empresa->direccion             = $request->get('direccion');
        $empresa->numero_celular        = $request->get('numero_celular_empresa');
        $empresa->email                 = $request->get('email');
        $empresa->autorizacion_datos    = true;

        if ($empresa->save()) {
            return redirect()->back()->with('estado', 'Your update processed correctly');
        } else {
            return redirect()->back()->with('estado', 'Hubo probema al guardar');
        }
    }
}
