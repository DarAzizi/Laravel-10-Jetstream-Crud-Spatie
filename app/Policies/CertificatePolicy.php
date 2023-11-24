<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Certificate;
use Illuminate\Auth\Access\HandlesAuthorization;

class CertificatePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the certificate can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list certificates');
    }

    /**
     * Determine whether the certificate can view the model.
     */
    public function view(User $user, Certificate $model): bool
    {
        return $user->hasPermissionTo('view certificates');
    }

    /**
     * Determine whether the certificate can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create certificates');
    }

    /**
     * Determine whether the certificate can update the model.
     */
    public function update(User $user, Certificate $model): bool
    {
        return $user->hasPermissionTo('update certificates');
    }

    /**
     * Determine whether the certificate can delete the model.
     */
    public function delete(User $user, Certificate $model): bool
    {
        return $user->hasPermissionTo('delete certificates');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete certificates');
    }

    /**
     * Determine whether the certificate can restore the model.
     */
    public function restore(User $user, Certificate $model): bool
    {
        return false;
    }

    /**
     * Determine whether the certificate can permanently delete the model.
     */
    public function forceDelete(User $user, Certificate $model): bool
    {
        return false;
    }
}
