<?php

namespace App\Http\Middleware;

use App\Models\Nodo;
use App\Models\Trimestre;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'csrf_token' => csrf_token(),
            'auth' => [
                'user'                      => $request->user() ? $request->user()->only('id', 'name',  'email', 'empresa_id', 'institucion_educativa_id', 'roles', 'can', 'can_by_user', 'nodo_id') : null,
                'numeroNotificaciones'      => $request->user() ? $request->user()->unreadNotifications()->count() : 0,
                'nodos'                     => $request->user() ? Nodo::select('id', 'departamento')->orderBy('departamento')->get() : []
            ],
            'flash' => function () {
                return [
                    'success'   => Session::get('success'),
                    'error'     => Session::get('error'),
                ];
            },
        ]);
    }
}
