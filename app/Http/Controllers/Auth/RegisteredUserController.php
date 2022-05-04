<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Empresa;
use App\Models\InstitucionEducativa;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return Inertia::render('Auth/Register', [
            'institucionesEducativas'   => InstitucionEducativa::select('id as value', 'nombre as label')->orderBy('nombre')->get(),
            'tipoUsuario'               => str_replace("=", "", $request->get('tipoUsuario')),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        $filePath = null;

        if ($request->hasFile('cv')) {
            $file       = $request->file('cv');
            $extension  = $file->extension();
            $fileName   = Str::slug(substr($request->name, 0, 20)) . "-RREDSI-cv" . time() . $extension;
            Storage::putFileAs(
                'public/hojas-vida-estudiantes',
                $file,
                $fileName
            );

            $filePath  = "hojas-vida-estudiantes/$fileName";
        }

        if ($request->tipo_usuario == 'rredsi') {
            $user = User::create([
                'name'                              => $request->name,
                'email'                             => $request->email,
                'password'                          => Hash::make($request->password),
                'tipo_documento'                    => $request->tipo_documento,
                'numero_documento'                  => $request->numero_documento,
                'numero_celular'                    => $request->numero_celular,
                'intereses'                         => $request->intereses,
                'esta_habilitado'                   => true,
                'cv'                                => $filePath,
                'perfil'                            => $request->perfil,
                'cvlac'                             => $request->cvlac,
                'autorizacion_tratamiento_datos'    => $request->autorizacion_tratamiento_datos,
                'institucion_educativa_id'          => $request->institucion_educativa_id,
            ]);

            $user->syncRoles([4]);
        } else if ($request->tipo_usuario == 'empresario') {
            $empresa = Empresa::create([
                'nit'            => $request->nit,
                'nombre'         => $request->nombre_empresa,
                'direccion'      => $request->direccion_empresa,
                'numero_celular' => $request->numero_celular_empresa,
                'email'          => $request->email_empresa,
            ]);

            $user = User::create([
                'name'                              => $request->name,
                'email'                             => $request->email,
                'password'                          => Hash::make($request->password),
                'tipo_documento'                    => $request->tipo_documento,
                'numero_documento'                  => $request->numero_documento,
                'numero_celular'                    => $request->numero_celular,
                'empresa_id'                        => $empresa->id,
                'esta_habilitado'                   => true,
                'autorizacion_tratamiento_datos'    => $request->autorizacion_tratamiento_datos,
            ]);

            $user->syncRoles([5]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
