<?php

namespace App\Policies;

use App\Models\User;
use App\Models\DrawingLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrawingLogPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the drawingLog can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list drawinglogs');
    }

    /**
     * Determine whether the drawingLog can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawingLog  $model
     * @return mixed
     */
    public function view(User $user, DrawingLog $model)
    {
        return $user->hasPermissionTo('view drawinglogs');
    }

    /**
     * Determine whether the drawingLog can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create drawinglogs');
    }

    /**
     * Determine whether the drawingLog can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawingLog  $model
     * @return mixed
     */
    public function update(User $user, DrawingLog $model)
    {
        return $user->hasPermissionTo('update drawinglogs');
    }

    /**
     * Determine whether the drawingLog can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawingLog  $model
     * @return mixed
     */
    public function delete(User $user, DrawingLog $model)
    {
        return $user->hasPermissionTo('delete drawinglogs');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawingLog  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete drawinglogs');
    }

    /**
     * Determine whether the drawingLog can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawingLog  $model
     * @return mixed
     */
    public function restore(User $user, DrawingLog $model)
    {
        return false;
    }

    /**
     * Determine whether the drawingLog can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\DrawingLog  $model
     * @return mixed
     */
    public function forceDelete(User $user, DrawingLog $model)
    {
        return false;
    }
}
