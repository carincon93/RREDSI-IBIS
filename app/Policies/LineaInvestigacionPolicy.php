<?php

namespace App\Policies;

use App\Models\InstitucionEducativa;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\LineaInvestigacion;
use App\Models\User;

class LineaInvestigacionPolicy
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

        if ($user->getAllPermissions()->whereIn('id', [5, 6])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LineaInvestigacion  $lineaInvestigacion
     * @return mixed
     */
    public function view(User $user, InstitucionEducativa $institucionEducativa, LineaInvestigacion $lineaInvestigacion)
    {
        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [5, 6])->count() > 0) {
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

        if ($user->getAllPermissions()->whereIn('id', [5])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LineaInvestigacion  $lineaInvestigacion
     * @return mixed
     */
    public function update(User $user, InstitucionEducativa $institucionEducativa, LineaInvestigacion $lineaInvestigacion)
    {
        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [5])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LineaInvestigacion  $lineaInvestigacion
     * @return mixed
     */
    public function delete(User $user, InstitucionEducativa $institucionEducativa, LineaInvestigacion $lineaInvestigacion)
    {
        if ($user->institucion_educativa_id != $institucionEducativa->id) {
            return false;
        }

        if ($user->getAllPermissions()->whereIn('id', [5])->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LineaInvestigacion  $lineaInvestigacion
     * @return mixed
     */
    public function restore(User $user, LineaInvestigacion $lineaInvestigacion)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LineaInvestigacion  $lineaInvestigacion
     * @return mixed
     */
    public function forceDelete(User $user, LineaInvestigacion $lineaInvestigacion)
    {
        //
    }
}
