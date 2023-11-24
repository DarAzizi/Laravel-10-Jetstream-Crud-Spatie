<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Graduation;
use Illuminate\Auth\Access\HandlesAuthorization;

class GraduationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the graduation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list graduations');
    }

    /**
     * Determine whether the graduation can view the model.
     */
    public function view(User $user, Graduation $model): bool
    {
        return $user->hasPermissionTo('view graduations');
    }

    /**
     * Determine whether the graduation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create graduations');
    }

    /**
     * Determine whether the graduation can update the model.
     */
    public function update(User $user, Graduation $model): bool
    {
        return $user->hasPermissionTo('update graduations');
    }

    /**
     * Determine whether the graduation can delete the model.
     */
    public function delete(User $user, Graduation $model): bool
    {
        return $user->hasPermissionTo('delete graduations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete graduations');
    }

    /**
     * Determine whether the graduation can restore the model.
     */
    public function restore(User $user, Graduation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the graduation can permanently delete the model.
     */
    public function forceDelete(User $user, Graduation $model): bool
    {
        return false;
    }
}
