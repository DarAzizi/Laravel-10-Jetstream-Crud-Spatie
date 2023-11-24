<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Remark;
use Illuminate\Auth\Access\HandlesAuthorization;

class RemarkPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the remark can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list remarks');
    }

    /**
     * Determine whether the remark can view the model.
     */
    public function view(User $user, Remark $model): bool
    {
        return $user->hasPermissionTo('view remarks');
    }

    /**
     * Determine whether the remark can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create remarks');
    }

    /**
     * Determine whether the remark can update the model.
     */
    public function update(User $user, Remark $model): bool
    {
        return $user->hasPermissionTo('update remarks');
    }

    /**
     * Determine whether the remark can delete the model.
     */
    public function delete(User $user, Remark $model): bool
    {
        return $user->hasPermissionTo('delete remarks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete remarks');
    }

    /**
     * Determine whether the remark can restore the model.
     */
    public function restore(User $user, Remark $model): bool
    {
        return false;
    }

    /**
     * Determine whether the remark can permanently delete the model.
     */
    public function forceDelete(User $user, Remark $model): bool
    {
        return false;
    }
}
