<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the book can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list books');
    }

    /**
     * Determine whether the book can view the model.
     */
    public function view(User $user, Book $model): bool
    {
        return $user->hasPermissionTo('view books');
    }

    /**
     * Determine whether the book can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create books');
    }

    /**
     * Determine whether the book can update the model.
     */
    public function update(User $user, Book $model): bool
    {
        return $user->hasPermissionTo('update books');
    }

    /**
     * Determine whether the book can delete the model.
     */
    public function delete(User $user, Book $model): bool
    {
        return $user->hasPermissionTo('delete books');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete books');
    }

    /**
     * Determine whether the book can restore the model.
     */
    public function restore(User $user, Book $model): bool
    {
        return false;
    }

    /**
     * Determine whether the book can permanently delete the model.
     */
    public function forceDelete(User $user, Book $model): bool
    {
        return false;
    }
}
