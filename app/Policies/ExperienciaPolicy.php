<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Experiencia;
use App\Models\User;

class ExperienciaPolicy
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
        if ($user->getAllPermissions()->whereIn('id', [29, 30])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Experiencia  $experiencia
     * @return mixed
     */
    public function view(User $user, Experiencia $experiencia)
    {
        if ($user->getAllPermissions()->whereIn('id', [29, 30])->count() > 0) {
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
        if ($user->getAllPermissions()->whereIn('id', [29])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Experiencia  $experiencia
     * @return mixed
     */
    public function update(User $user, Experiencia $experiencia)
    {
        if ($experiencia->empresa_id == $user->empresa_id && $user->getAllPermissions()->whereIn('id', [29])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Experiencia  $experiencia
     * @return mixed
     */
    public function delete(User $user, Experiencia $experiencia)
    {
        if ($experiencia->empresa_id == $user->empresa_id && $user->getAllPermissions()->whereIn('id', [29])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Experiencia  $experiencia
     * @return mixed
     */
    public function restore(User $user, Experiencia $experiencia)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Experiencia  $experiencia
     * @return mixed
     */
    public function forceDelete(User $user, Experiencia $experiencia)
    {
        //
    }
}
