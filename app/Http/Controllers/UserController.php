<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\Empresa;
use App\Models\InstitucionEducativa;
use App\Models\SemilleroInvestigacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $institucionEducativaId = str_replace("=", "", $request->get('institucionEducativaId'));
        $semilleroId = str_replace("=", "", $request->get('semilleroId'));

        $users = [];
        $semilleroInvestigacion = null;

        if ($semilleroId) {
            $semilleroInvestigacion = SemilleroInvestigacion::find($semilleroId);

            $users = $semilleroInvestigacion->miembros()->select('users.*')->filterUser(request()->only('search'))->paginate()->appends(['search' => request()->search]);
        } else if ($institucionEducativaId != "undefined" && $institucionEducativaId != "") {
            $users = User::orderBy('name')->filterUser(request()->only('search'))->where('institucion_educativa_id', $institucionEducativaId)->paginate()->appends(['search' => request()->search]);
        } else {
            $users = User::orderBy('name')->filterUser(request()->only('search'))->paginate()->appends(['search' => request()->search]);
        }

        return Inertia::render('Users/Index', [
            'users'                     => $users,
            'institucionEducativa'      => InstitucionEducativa::where('id', $institucionEducativaId)->first(),
            'semilleroInvestigacion'    => $semilleroInvestigacion
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $institucionEducativaId = str_replace("=", "", $request->get('institucionEducativaId'));

        $semilleroId = str_replace("=", "", $request->get('semilleroId'));
        $semilleroInvestigacion = null;
        if ($semilleroId) {
            $semilleroInvestigacion = SemilleroInvestigacion::find($semilleroId);
        }

        $roles = null;

        if (auth()->user()->hasRole([1, 2])) {
            $roles = Role::select('id as value', 'name as label')->orderBy('name')->get();
        } else if (auth()->user()->hasRole(3)) {
            $roles = Role::select('id as value', 'name as label')->whereNotIn('id', [1, 2, 3])->orderBy('name')->get();
        }

        return Inertia::render('Users/Create', [
            'roles'                     => $roles,
            'institucionesEducativas'   => InstitucionEducativa::select('id as value', 'nombre as label')->orderBy('nombre')->get(),
            'institucionEducativa'      => InstitucionEducativa::where('id', $institucionEducativaId)->first(),
            'semilleroInvestigacion'    => $semilleroInvestigacion
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $institucionEducativaId = str_replace("=", "", $request->get('institucionEducativaId'));

        $user = new User;
        $user->name                             = $request->name;
        $user->email                            = $request->email;
        $user->password                         = bcrypt($request->password);
        $user->tipo_documento                   = $request->tipo_documento;
        $user->numero_documento                 = $request->numero_documento;
        $user->numero_celular                   = $request->numero_celular;
        $user->intereses                        = $request->intereses;
        $user->perfil                           = $request->perfil;
        $user->cvlac                            = $request->cvlac;
        $user->esta_habilitado                  = $request->esta_habilitado;
        $user->autorizacion_tratamiento_datos   = $request->autorizacion_tratamiento_datos;

        if ($request->hasFile('cv')) {
            $file       = $request->file('cv');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($request->name, 0, 20)) . "-RREDSI-cv" . time() . $extension;
            Storage::putFileAs(
                'public/hojas-vida-estudiantes',
                $file,
                $fileName
            );

            $user->cv  = "hojas-vida-estudiantes/$fileName";
        }

        $user->institucionEducativa()->associate($request->institucion_educativa_id);

        $user->save();
        $user->syncRoles($request->rol_id);

        if ($request->tipo_usuario == 'empresario') {
            $empresa = new Empresa();
            $empresa->nit            = $request->nit;
            $empresa->nombre         = $request->nombre_empresa;
            $empresa->direccion      = $request->direccion_empresa;
            $empresa->numero_celular = $request->numero_celular_empresa;
            $empresa->email          = $request->email_empresa;

            $empresa->save();

            $user->update(['empresa_id' => $empresa->id]);
        }

        if ($request->semillero_investigacion_id) {
            $user->semillerosInvestigacion()->attach($request->semillero_investigacion_id);
            return redirect()->route('users.index', ['institucionEducativaId=' . $request->institucion_educativa_id, 'semilleroId=' . $request->semillero_investigacion_id]);
        } else if ($institucionEducativaId == '') {
            return redirect()->route('users.index')->with('success', 'El usuario se ha creado correctamente.');
        }

        return redirect()->route('users.index', ['institucionEducativaId=' . $request->institucion_educativa_id])->with('success', 'El usuario se ha creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $institucionEducativaId = str_replace("=", "", $request->get('institucionEducativaId'));

        $user->estudios;
        $user->semillerosInvestigacion;
        $user->proyectos;

        $semilleroId = str_replace("=", "", $request->get('semilleroId'));
        $semilleroInvestigacion = null;
        if ($semilleroId) {
            $semilleroInvestigacion = SemilleroInvestigacion::find($semilleroId);
        }

        return Inertia::render('Users/Show', [
            'user'                      => $user,
            'institucionEducativa'      => InstitucionEducativa::where('id', $institucionEducativaId)->first(),
            'semilleroInvestigacion'    => $semilleroInvestigacion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $institucionEducativaId = str_replace("=", "", $request->get('institucionEducativaId'));
        $semilleroId = str_replace("=", "", $request->get('semilleroId'));
        $semilleroInvestigacion = null;
        if ($semilleroId) {
            $semilleroInvestigacion = SemilleroInvestigacion::find($semilleroId);
        }

        $user->empresa;

        $roles = null;

        if (auth()->user()->hasRole([1, 2])) {
            $roles = Role::select('id as value', 'name as label')->orderBy('name')->get();
        } else if (auth()->user()->hasRole(3)) {
            $roles = Role::select('id as value', 'name as label')->whereNotIn('id', [1, 2, 3])->orderBy('name')->get();
        }

        return Inertia::render('Users/Edit', [
            'user'                      => $user,
            'institucionesEducativas'   => InstitucionEducativa::select('id as value', 'nombre as label')->orderBy('nombre')->get(),
            'roles'                     => $roles,
            'rolesRelacionados'         => $user->roles()->select('roles.id as value', 'roles.name as label')->get(),
            'institucionEducativa'      => InstitucionEducativa::where('id', $institucionEducativaId)->first(),
            'semilleroInvestigacion'    => $semilleroInvestigacion
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $institucionEducativaId = str_replace("=", "", $request->get('institucionEducativaId'));

        $user->name                             = $request->name;
        $user->email                            = $request->email;
        $user->password                         = bcrypt($request->password);
        $user->tipo_documento                   = $request->tipo_documento;
        $user->numero_documento                 = $request->numero_documento;
        $user->numero_celular                   = $request->numero_celular;
        $user->intereses                        = $request->intereses;
        $user->perfil                           = $request->perfil;
        $user->cvlac                            = $request->cvlac;
        $user->esta_habilitado                  = $request->esta_habilitado;
        $user->autorizacion_tratamiento_datos   = $request->autorizacion_tratamiento_datos;

        if ($request->hasFile('cv')) {
            Storage::delete("public/$user->cv");
            $file       = $request->file('cv');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($request->name, 0, 20)) . "-RREDSI-cv" . time() . $extension;
            Storage::putFileAs(
                'public/hojas-vida-estudiantes',
                $file,
                $fileName
            );

            $user->cv  = "hojas-vida-estudiantes/$fileName";
        }

        $user->institucionEducativa()->associate($request->institucion_educativa_id);

        if ($request->defaultPassword) {
            $user->password = $user::makePassword($request->numero_documento);
        }

        $user->save();
        $user->syncRoles($request->rol_id);

        if ($request->tipo_usuario == 'empresario') {
            if ($user->empresa()->exists()) {
                $user->empresa()->update([
                    'nit'               => $request->nit,
                    'nombre'            => $request->nombre_empresa,
                    'direccion'         => $request->direccion_empresa,
                    'numero_celular'    => $request->numero_celular_empresa,
                    'email'             => $request->email_empresa
                ]);
            } else {
                $empresa = Empresa::create([
                    'nit'               => $request->nit,
                    'nombre'            => $request->nombre_empresa,
                    'direccion'         => $request->direccion_empresa,
                    'numero_celular'    => $request->numero_celular_empresa,
                    'email'             => $request->email_empresa
                ]);

                $user->update([
                    'empresa_id' => $empresa->id
                ]);
            }
        }

        if ($request->semillero_investigacion_id) {
            $user->semillerosInvestigacion()->sync($request->semillero_investigacion_id);
            return redirect()->route('users.index', ['institucionEducativaId=' . $request->institucion_educativa_id, 'semilleroId=' . $request->semillero_investigacion_id]);
        } else if ($institucionEducativaId == '') {
            return redirect()->route('users.index')->with('success', 'El usuario se ha creado correctamente.');
        }

        return redirect()->route('users.index', ['institucionEducativaId=' . $request->institucion_educativa_id])->with('success', 'El usuario se ha modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'El usuario se ha eliminado correctamente.');
    }

    /**
     * Show user's profile.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function perfil()
    {
        $user = Auth::user();
        $user->empresa;

        return Inertia::render('Users/Perfil', [
            'user' => $user
        ]);
    }

    /**
     * Actualizar perfil
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function actualizarPerfil(PerfilRequest $request)
    {
        $user = Auth::user();
        $user->name                             = $request->name;
        $user->email                            = $request->email;
        $user->tipo_documento                   = $request->tipo_documento;
        $user->numero_documento                 = $request->numero_documento;
        $user->numero_celular                   = $request->numero_celular;
        $user->intereses                        = $request->intereses;
        $user->perfil                           = $request->perfil;
        $user->cvlac                            = $request->cvlac;
        $user->autorizacion_tratamiento_datos   = $request->autorizacion_tratamiento_datos;

        if ($request->hasFile('cv')) {
            $file       = $request->file('cv');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($request->name, 0, 20)) . "-RREDSI-cv" . time() . $extension;
            Storage::putFileAs(
                'public/hojas-vida-estudiantes',
                $file,
                $fileName
            );

            $user->cv  = "hojas-vida-estudiantes/$fileName";
        }

        if ($request->password) {
            $user->password = $request->password;
        }

        $user->save();

        if ($user->empresa()->exists()) {
            $user->empresa()->update([
                'nit'               => $request->nit,
                'nombre'            => $request->nombre_empresa,
                'direccion'         => $request->direccion_empresa,
                'numero_celular'    => $request->numero_celular_empresa,
                'email'             => $request->email_empresa
            ]);
        }

        return back()->with('success', 'Se ha actualizado la información correctamente.');
    }
}
