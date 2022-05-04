<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [Producto::class]);

        $user       = auth()->user();
        $empresa    = $user->empresa()->first();

        return Inertia::render('Productos/Index', [
            'empresa'       => $empresa,
            'productos'     => Producto::where('empresa_id', '=', $empresa ? $empresa->id : null)->filterProducto(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [Producto::class]);

        return Inertia::render('Productos/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductoRequest $request)
    {
        $this->authorize('create', [Producto::class]);

        if (auth()->user()->empresa()->first()) {

            $producto = new Producto();
            $producto->nombre         = $request->nombre;
            $producto->descripcion    = $request->descripcion;
            $producto->empresa()->associate(auth()->user()->empresa()->first()->id);

            $file = $request->image;
            if ($request->hasFile('image')) {
                $file = $request->file('image')->store('imagenes-productos', 'public');
                $producto->image = $file;
            }
            if ($producto->save()) {
                return redirect()->back()->with('success', 'Producto creado con exito');
            } else {
                return redirect()->back()->with('error', 'Hubo un error almacenando el producto');
            }
        } else {
            return redirect()->back()->with('error', 'No está asociado a ninguna empresa. Por favor comuníquese con el administrador del sistema.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        $this->authorize('view', [Producto::class, $producto]);

        $producto->empresa->user;

        return Inertia::render('Productos/Show', [
            'producto' => $producto,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        $this->authorize('update', [Producto::class, $producto]);

        // $user       = auth()->user();
        // $empresa    = $user->empresa()->first();

        return Inertia::render('Productos/Edit', [
            'producto' => $producto
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(ProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', [Producto::class, $producto]);

        $producto->nombre       = $request->nombre;
        $producto->descripcion  = $request->descripcion;
        $file                   = $request->image;

        if ($request->hasFile('image')) {
            Storage::delete("public/$producto->image");
            $file = $request->file('image')->store('imagenes-productos', 'public');
            $producto->image = $file;
        }

        if ($producto->save()) {
            return redirect()->back()->with('success', 'Producto editado correctamente');
        } else {
            return redirect()->back()->with('error', 'Hubo un error al editar el producto');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $this->authorize('delete', [Producto::class, $producto]);

        Storage::delete('public/' . $producto->image);

        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }

    public function buscarProveedores()
    {
        $user       = auth()->user();
        $empresa    = $user->empresa()->first();

        return Inertia::render('Productos/TodosProductos', [
            'empresa'       => $empresa,
            'productos'     => Producto::filterProducto(request()->only('search'))->paginate(),
        ]);
    }
}
