<?php

namespace App\Policies;

use App\Models\InstitucionEducativa;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Proyecto;
use App\Models\User;

class ProyectoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user, InstitucionEducativa $institucionEducativa)
    {
        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [13, 14])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function view(User $user, InstitucionEducativa $institucionEducativa, Proyecto $proyecto)
    {
        if ($user->hasRole(5) && $user->getAllPermissions()->whereIn('id', [13, 14])->count() > 0) {
            return true;
        }

        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($proyecto->privado == true && !$proyecto->autores()->where('autores.user_id', $user->id)->exists()) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [13, 14])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, InstitucionEducativa $institucionEducativa)
    {
        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [13])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function update(User $user, InstitucionEducativa $institucionEducativa, Proyecto $proyecto)
    {
        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->hasRole([3]) || $user->getAllPermissions()->whereIn('id', [13])->count() > 0 && $proyecto->autores()->where('autores.user_id', $user->id)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function delete(User $user, InstitucionEducativa $institucionEducativa, Proyecto $proyecto)
    {
        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->hasRole([3]) || $user->getAllPermissions()->whereIn('id', [13])->count() > 0 && $proyecto->autores()->where('autores.user_id', $user->id)->exists()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function restore(User $user, Proyecto $proyecto)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Proyecto  $proyecto
     * @return mixed
     */
    public function forceDelete(User $user, Proyecto $proyecto)
    {
        //
    }
}
