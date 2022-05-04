<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Nodo;
use App\Models\User;

class NodoPolicy
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
        if ($user->getAllPermissions()->whereIn('id', [21, 22])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Nodo  $nodo
     * @return mixed
     */
    public function view(User $user, Nodo $nodo)
    {
        if ($user->institucionEducativa && $user->institucionEducativa->nodo_id == $nodo->id && $user->getAllPermissions()->whereIn('id', [21, 22])->count() > 0) {
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
        // if ($user->getAllPermissions()->whereIn('id', [21])->count() > 0) {
        //     return true;
        // }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Nodo  $nodo
     * @return mixed
     */
    public function update(User $user, Nodo $nodo)
    {
        if ($user->institucionEducativa && $user->institucionEducativa->nodo_id == $nodo->id && $user->getAllPermissions()->whereIn('id', [21])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Nodo  $nodo
     * @return mixed
     */
    public function delete(User $user, Nodo $nodo)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Nodo  $nodo
     * @return mixed
     */
    public function restore(User $user, Nodo $nodo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Nodo  $nodo
     * @return mixed
     */
    public function forceDelete(User $user, Nodo $nodo)
    {
        //
    }
}
