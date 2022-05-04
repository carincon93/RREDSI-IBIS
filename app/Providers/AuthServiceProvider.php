<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\AmbienteFormacion'      => 'App\Policies\AmbienteFormacionPolicy',
        'App\Models\Convocatoria'           => 'App\Policies\ConvocatoriaPolicy',
        'App\Models\EquipoFormacion'        => 'App\Policies\EquipoFormacionPolicy',
        'App\Models\Evento'                 => 'App\Policies\EventoPolicy',
        'App\Models\Experiencia'            => 'App\Policies\ExperienciaPolicy',
        'App\Models\Facultad'               => 'App\Policies\FacultadPolicy',
        'App\Models\GrupoInvestigacion'     => 'App\Policies\GrupoInvestigacionPolicy',
        'App\Models\IdeaEmpresa'            => 'App\Policies\IdeaEmpresaPolicy',
        'App\Models\InstitucionEducativa'   => 'App\Policies\InstitucionEducativaPolicy',
        'App\Models\LineaInvestigacion'     => 'App\Policies\LineaInvestigacionPolicy',
        'App\Models\Nodo'                   => 'App\Policies\NodoPolicy',
        'App\Models\Producto'               => 'App\Policies\ProductoPolicy',
        'App\Models\ProgramaAcademico'      => 'App\Policies\ProgramaAcademicoPolicy',
        'App\Models\Proyecto'               => 'App\Policies\ProyectoPolicy',
        'App\Models\Role'                   => 'App\Policies\RolePolicy',
        'App\Models\SemilleroInvestigacion' => 'App\Policies\SemilleroInvestigacionPolicy',
        'App\Models\User'                   => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerSuperAdminPolicy();
    }

    public function registerSuperAdminPolicy()
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole(1) ? true : null;
        });
    }
}
