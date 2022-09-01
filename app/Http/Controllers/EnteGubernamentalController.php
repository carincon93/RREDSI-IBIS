<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EnteGubernamental;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;


class EnteGubernamentalController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('EnteGubernamental/Index');
    }
    public function login(){
        return Inertia::render('EnteGubernamental/Login');
    }

    public function loginEnte(Request $request){

        $email = $request ->email ;
        $pass = $request ->password;

        var_dump($email);

        $exist = User::where('email', '=', $email)->exists();

        if ($exist) {
            return Inertia::render('EnteGubernamental/Index',);
        }
        else {
            return back()->with('error', 'verifique la información ingresada.');
        }
    }

    public function create(){
        return Inertia::render('EnteGubernamental/Create',);
    }


    /*
    public function formulary(Request $request){

        $entityName = $request ->email;
        $nit = $request ->password;

        $phone = $request ->email ;
        $city = $request ->password;
        $direction = $request ->email ;

        $managerName = $request ->password;
        $document = $request ->email ;
        $phoneNumber = $request ->password;
        $email = $request ->email ;
        $password = $request ->password;

        var_dump($email);

        $exist = User::where('email', '=', $email)->exists();

        if ($exist) {
            return Inertia::render('EnteGubernamental/Index',);
        }
        else {
            return back()->with('error', 'verifique la información ingresada.');
        }

    }

    */


    public function store(Request $request){

        $nombre    = $request->nombreEntidad;
        $nit       = $request->nit;
        $telefono  = $request->telefono;
        $ciudad    = $request->ciudad;
        $direccion = $request->direccion;

        $entidad = new EnteGubernamental();
        $entidad->nombre = $nombre;
        $entidad->nit = $nit;
        $entidad->telefono = $telefono;
        $entidad->ciudad = $ciudad;
        $entidad->direccion = $direccion;

    

        $entidad->save();

        return Inertia::render('EnteGubernamental/index');


        /*
        $EnteGubernamental = new EnteGubernamental();
        $EnteGubernamental->nombreEntidad        = $request->nombreEntidad;
        $EnteGubernamental->nit                  = $request->nit;
        $EnteGubernamental->telefono             = $request->telefono;
        $EnteGubernamental->ciudad               = $request->ciudad;
        $EnteGubernamental->direccion            = $request->direccion;

        $EnteGubernamental -> save();

        return Inertia::render('EnteGubernamental/Show');
        */
    }


    //Capturar datos
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*
     public function store2(entegubernamentalRequest $request)
    {
        $this->authorize('create', [EnteGubernamental::class]);

        $EnteGubernamental = new EnteGubernamental();
        $EnteGubernamental->nombreEntidad        = $request->nombreEntidad;
        $EnteGubernamental->nit                  = $request->nit;
        $EnteGubernamental->telefono             = $request->detalles;
        $EnteGubernamental->ciudad               = $request->fecha_inicio;
        $EnteGubernamental->direccion            = $request->fecha_finalizacion;


        if ($EnteGubernamental->save()) {
            return redirect()->back()->with('success', 'Ente Gubernamentl agregado con exito');
        } else {

            return redirect()->back()->with('error', 'Hubo un error al agregar al Ente Gubernamental');
        }
    }

    */

    public function show(){

        return Inertia::render('EnteGubernamental/Show');

    }





}
