<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\IdeaEmpresa;
use App\Models\User;

class IdeaEmpresaPolicy
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
        if ($user->getAllPermissions()->whereIn('id', [31, 32])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IdeaEmpresa  $ideaEmpresa
     * @return mixed
     */
    public function view(User $user, IdeaEmpresa $ideaEmpresa)
    {
        if ($user->getAllPermissions()->whereIn('id', [31, 32])->count() > 0) {
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
        if ($user->getAllPermissions()->whereIn('id', [31])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IdeaEmpresa  $ideaEmpresa
     * @return mixed
     */
    public function update(User $user, IdeaEmpresa $ideaEmpresa)
    {
        if ($user->empresa_id && $ideaEmpresa->empresa_id && $user->getAllPermissions()->whereIn('id', [31])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IdeaEmpresa  $ideaEmpresa
     * @return mixed
     */
    public function delete(User $user, IdeaEmpresa $ideaEmpresa)
    {
        if ($user->empresa_id && $ideaEmpresa->empresa_id && $user->getAllPermissions()->whereIn('id', [31])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IdeaEmpresa  $ideaEmpresa
     * @return mixed
     */
    public function restore(User $user, IdeaEmpresa $ideaEmpresa)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\IdeaEmpresa  $ideaEmpresa
     * @return mixed
     */
    public function forceDelete(User $user, IdeaEmpresa $ideaEmpresa)
    {
        //
    }
}
