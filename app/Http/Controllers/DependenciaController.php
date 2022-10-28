<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EnteGubernamental;//Hay que crear el modelo
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DependenciaController extends Controller
{
    //

    public function index()
    {
        return Inertia::render('Dependencia/Index', [
            /* 'filters'   => request()->all('search'),
            'entes'     => Dependencia::orderBy('name', 'ASC')
                ->FilterDependencia(request()->only('search'))->paginate(), */
        ]);
    }

    public function create()
    {
        return Inertia::render('Dependencia/Create', [
            'municipios'     => DB::select('select id,municipio from municipios'),
            'delegados'  => DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->select('users.name', 'users.id')
                ->where('roles.name', '=', 'Delegado de la entidad')
                ->get()
        ]);
    }

    /*
    public function store(Request $request)
    {

        $name = $request->name;
        $direction = $request->direction;
        $phone = $request->phone;
        $nit = $request->nit;
        $city = $request->city;
        $id_delegado_entidad = $request->id_delegado_entidad;

        $entidadGubernamental = new EnteGubernamental();
        $entidadGubernamental->name = $name;
        $entidadGubernamental->direction = $direction;
        $entidadGubernamental->phone = $phone;
        $entidadGubernamental->nit = $nit;
        $entidadGubernamental->city = $city;
        $entidadGubernamental->id_delegado_entidad = $id_delegado_entidad;

        $entidadGubernamental->save();

        return redirect()->route('ente-gubernamental.index')->with('success', 'El recurso se ha creado correctamente.');
    }

    public function edit($id)
    {



        return Inertia::render('EnteGubernamental/Edit', [
            'filters'   => request()->all('search'),
            'ente'      => EnteGubernamental::where('id', $id)
                ->FilterEnteGubernamental(request()->only('search'))->paginate(),
        ]);



    }

    public function update(Request $request, EnteGubernamental $ente)
    {

        $ente -> name   = $request -> name;
        $ente -> direction   = $request -> direccion;
        $ente -> phone   = $request -> phone;
        $ente -> nit   = $request -> nit;
        $ente -> city   = $request -> city;
        $ente -> id_delegado_entidad   = $request -> id_delegado_entidad;


        $idEntidad =$request->idEntidad ;

        EnteGubernamental::where('id', $idEntidad)
        ->update([
                'name' => $request->name,
                'direction' => $request->direction,
                'phone' => $request->phone,
                'nit' => $request->nit,
                'city' => $request->city,
                'id_delegado_entidad' => $request->id_delegado_entidad,
        ]);
        return redirect()->route('ente-gubernamental.index')->with('success', 'El recurso se ha Actualizado correctamente.');

    }

    public function loguin()
    {
        return Inertia::render('EnteGubernamental/Login', [
            'filters'   => request()->all('search'),
            'entes'     => EnteGubernamental::orderBy('name', 'ASC')
                ->FilterEnteGubernamental(request()->only('search'))->paginate(),
        ]);
    }

    public function log(Request $request)
    {


        $email = $request->email;
        $pass = $request->password;
        $dbPass = User::select('password')->where('email', '=', $email)->first();

        if (Hash::check($pass, $dbPass->password)) {
            return Inertia::render('EnteGubernamental/Index', [
                'filters'   => request()->all('search'),
                'entes'     => EnteGubernamental::orderBy('name', 'ASC')
                    ->FilterEnteGubernamental(request()->only('search'))->paginate(),
            ]);
        } else {
            return Inertia::render('EnteGubernamental/Login')->with('error', 'Error.');
        }
    }

    public function destroy($ide)
    {
        $ide;
        $exist = EnteGubernamental::where('id', '=', $ide)->exists();

        if ($exist) {
            EnteGubernamental::where('id', $ide)->delete();
            return redirect()->route('ente-gubernamental.index')->with('success', 'El recurso se ha eliminado correctamente.');
        } else {
            return redirect()->route('ente-gubernamental.index')->with('error', 'El recurso no existe.');
        }
    } */
}
