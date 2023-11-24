<?php

namespace App\Policies;

use App\Models\City;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the city can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list cities');
    }

    /**
     * Determine whether the city can view the model.
     */
    public function view(User $user, City $model): bool
    {
        return $user->hasPermissionTo('view cities');
    }

    /**
     * Determine whether the city can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create cities');
    }

    /**
     * Determine whether the city can update the model.
     */
    public function update(User $user, City $model): bool
    {
        return $user->hasPermissionTo('update cities');
    }

    /**
     * Determine whether the city can delete the model.
     */
    public function delete(User $user, City $model): bool
    {
        return $user->hasPermissionTo('delete cities');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete cities');
    }

    /**
     * Determine whether the city can restore the model.
     */
    public function restore(User $user, City $model): bool
    {
        return false;
    }

    /**
     * Determine whether the city can permanently delete the model.
     */
    public function forceDelete(User $user, City $model): bool
    {
        return false;
    }
}
