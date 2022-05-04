<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Producto;
use App\Models\User;

class ProductoPolicy
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
        if ($user->getAllPermissions()->whereIn('id', [27, 28])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Producto  $producto
     * @return mixed
     */
    public function view(User $user, Producto $producto)
    {
        if ($user->getAllPermissions()->whereIn('id', [27, 28])->count() > 0) {
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
        if ($user->getAllPermissions()->whereIn('id', [27])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Producto  $producto
     * @return mixed
     */
    public function update(User $user, Producto $producto)
    {
        if ($user->empresa_id == $producto->empresa_id && $user->getAllPermissions()->whereIn('id', [27])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Producto  $producto
     * @return mixed
     */
    public function delete(User $user, Producto $producto)
    {
        if ($user->empresa_id == $producto->empresa_id && $user->getAllPermissions()->whereIn('id', [27])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Producto  $producto
     * @return mixed
     */
    public function restore(User $user, Producto $producto)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Producto  $producto
     * @return mixed
     */
    public function forceDelete(User $user, Producto $producto)
    {
        //
    }
}
