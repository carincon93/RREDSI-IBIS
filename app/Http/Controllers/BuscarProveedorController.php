<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Empresa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuscarProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['productos'] = DB::table('productos')
            ->join('empresas', 'empresas.id', '=', 'productos.empresa_id')
            ->select('productos.*', 'empresas.nombre', 'empresas.numero_celular', 'empresas.email', 'empresas.direccion')
            ->paginate(10);
        return view('BuscarProveedores.index', $datos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SearchProviders  $searchProviders
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        $user       = auth()->user();
        $empresa    = $user->empresa()->first();
        $empresa    = Empresa::where('empresas.id', '=', $producto->empresa_id)->first();
        return view('BuscarProveedores.show', compact('producto', 'empresa'));
    }
}
