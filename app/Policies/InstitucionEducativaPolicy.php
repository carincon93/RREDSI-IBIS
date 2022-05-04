<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\InstitucionEducativa;
use App\Models\User;

class InstitucionEducativaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if ($user->hasRole([2]) || $user->getAllPermissions()->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 33, 34, 35, 36])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InstitucionEducativa  $institucionEducativa
     * @return mixed
     */
    public function view(User $user, InstitucionEducativa $institucionEducativa)
    {
        if ($user->hasRole([2]) && $user->institucionEducativa && $user->institucionEducativa->nodo_id == $institucionEducativa->nodo_id) {
            return true;
        }

        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 33, 34, 35, 36])->count() > 0) {
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
    public function create(User $user)
    {
        if ($user->getAllPermissions()->whereIn('id', [33])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InstitucionEducativa  $institucionEducativa
     * @return mixed
     */
    public function update(User $user, InstitucionEducativa $institucionEducativa)
    {
        if ($user->hasRole([2]) && $user->institucionEducativa && $user->institucionEducativa->nodo_id == $institucionEducativa->nodo_id) {
            return true;
        }

        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [33])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InstitucionEducativa  $institucionEducativa
     * @return mixed
     */
    public function delete(User $user, InstitucionEducativa $institucionEducativa)
    {
        if ($user->hasRole([2]) && $user->institucionEducativa && $user->institucionEducativa->nodo_id == $institucionEducativa->nodo_id) {
            return true;
        }

        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [33])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InstitucionEducativa  $institucionEducativa
     * @return mixed
     */
    public function restore(User $user, InstitucionEducativa $institucionEducativa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\InstitucionEducativa  $institucionEducativa
     * @return mixed
     */
    public function forceDelete(User $user, InstitucionEducativa $institucionEducativa)
    {
        //
    }
}
