<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DrawRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrawRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the drawRequest can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list drawrequests');
    }

    /**
     * Determine whether the drawRequest can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawRequest  $model
     * @return mixed
     */
    public function view(User $user, DrawRequest $model)
    {
        return $user->hasPermissionTo('view drawrequests');
    }

    /**
     * Determine whether the drawRequest can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create drawrequests');
    }

    /**
     * Determine whether the drawRequest can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawRequest  $model
     * @return mixed
     */
    public function update(User $user, DrawRequest $model)
    {
        return $user->hasPermissionTo('update drawrequests');
    }

    /**
     * Determine whether the drawRequest can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawRequest  $model
     * @return mixed
     */
    public function delete(User $user, DrawRequest $model)
    {
        return $user->hasPermissionTo('delete drawrequests');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawRequest  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete drawrequests');
    }

    /**
     * Determine whether the drawRequest can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawRequest  $model
     * @return mixed
     */
    public function restore(User $user, DrawRequest $model)
    {
        return false;
    }

    /**
     * Determine whether the drawRequest can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawRequest  $model
     * @return mixed
     */
    public function forceDelete(User $user, DrawRequest $model)
    {
        return false;
    }
}
