<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Country;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the country can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list countries');
    }

    /**
     * Determine whether the country can view the model.
     */
    public function view(User $user, Country $model): bool
    {
        return $user->hasPermissionTo('view countries');
    }

    /**
     * Determine whether the country can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create countries');
    }

    /**
     * Determine whether the country can update the model.
     */
    public function update(User $user, Country $model): bool
    {
        return $user->hasPermissionTo('update countries');
    }

    /**
     * Determine whether the country can delete the model.
     */
    public function delete(User $user, Country $model): bool
    {
        return $user->hasPermissionTo('delete countries');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete countries');
    }

    /**
     * Determine whether the country can restore the model.
     */
    public function restore(User $user, Country $model): bool
    {
        return false;
    }

    /**
     * Determine whether the country can permanently delete the model.
     */
    public function forceDelete(User $user, Country $model): bool
    {
        return false;
    }
}
