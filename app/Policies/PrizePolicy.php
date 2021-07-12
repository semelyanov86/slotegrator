<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Prize;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrizePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the prize can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list prizes');
    }

    /**
     * Determine whether the prize can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Prize  $model
     * @return mixed
     */
    public function view(User $user, Prize $model)
    {
        return $user->hasPermissionTo('view prizes');
    }

    /**
     * Determine whether the prize can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create prizes');
    }

    /**
     * Determine whether the prize can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Prize  $model
     * @return mixed
     */
    public function update(User $user, Prize $model)
    {
        return $user->hasPermissionTo('update prizes');
    }

    /**
     * Determine whether the prize can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Prize  $model
     * @return mixed
     */
    public function delete(User $user, Prize $model)
    {
        return $user->hasPermissionTo('delete prizes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Prize  $model
     * @return mixed
     */
    public function deleteAny(User $user)
    {
        return $user->hasPermissionTo('delete prizes');
    }

    /**
     * Determine whether the prize can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Prize  $model
     * @return mixed
     */
    public function restore(User $user, Prize $model)
    {
        return false;
    }

    /**
     * Determine whether the prize can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Prize  $model
     * @return mixed
     */
    public function forceDelete(User $user, Prize $model)
    {
        return false;
    }
}
