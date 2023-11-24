<?php

namespace App\Policies;

use App\Models\User;
use App\Models\University;
use Illuminate\Auth\Access\HandlesAuthorization;

class UniversityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the university can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list universities');
    }

    /**
     * Determine whether the university can view the model.
     */
    public function view(User $user, University $model): bool
    {
        return $user->hasPermissionTo('view universities');
    }

    /**
     * Determine whether the university can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create universities');
    }

    /**
     * Determine whether the university can update the model.
     */
    public function update(User $user, University $model): bool
    {
        return $user->hasPermissionTo('update universities');
    }

    /**
     * Determine whether the university can delete the model.
     */
    public function delete(User $user, University $model): bool
    {
        return $user->hasPermissionTo('delete universities');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete universities');
    }

    /**
     * Determine whether the university can restore the model.
     */
    public function restore(User $user, University $model): bool
    {
        return false;
    }

    /**
     * Determine whether the university can permanently delete the model.
     */
    public function forceDelete(User $user, University $model): bool
    {
        return false;
    }
}
