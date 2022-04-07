<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Drawing;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrawingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the drawing can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list drawings');
    }

    /**
     * Determine whether the drawing can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Drawing  $model
     * @return mixed
     */
    public function view(User $user, Drawing $model)
    {
        return $user->hasPermissionTo('view drawings');
    }

    /**
     * Determine whether the drawing can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create drawings');
    }

    /**
     * Determine whether the drawing can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Drawing  $model
     * @return mixed
     */
    public function update(User $user, Drawing $model)
    {
        return $user->hasPermissionTo('update drawings');
    }

    /**
     * Determine whether the drawing can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Drawing  $model
     * @return mixed
     */
    public function delete(User $user, Drawing $model)
    {
        return $user->hasPermissionTo('delete drawings');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Drawing  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete drawings');
    }

    /**
     * Determine whether the drawing can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Drawing  $model
     * @return mixed
     */
    public function restore(User $user, Drawing $model)
    {
        return false;
    }

    /**
     * Determine whether the drawing can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Drawing  $model
     * @return mixed
     */
    public function forceDelete(User $user, Drawing $model)
    {
        return false;
    }
}
