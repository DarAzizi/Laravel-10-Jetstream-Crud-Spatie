<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Result;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the result can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list results');
    }

    /**
     * Determine whether the result can view the model.
     */
    public function view(User $user, Result $model): bool
    {
        return $user->hasPermissionTo('view results');
    }

    /**
     * Determine whether the result can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create results');
    }

    /**
     * Determine whether the result can update the model.
     */
    public function update(User $user, Result $model): bool
    {
        return $user->hasPermissionTo('update results');
    }

    /**
     * Determine whether the result can delete the model.
     */
    public function delete(User $user, Result $model): bool
    {
        return $user->hasPermissionTo('delete results');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete results');
    }

    /**
     * Determine whether the result can restore the model.
     */
    public function restore(User $user, Result $model): bool
    {
        return false;
    }

    /**
     * Determine whether the result can permanently delete the model.
     */
    public function forceDelete(User $user, Result $model): bool
    {
        return false;
    }
}
