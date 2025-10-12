<?php
// app/Policies/UserPolicy.php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdmin();
    }

    /**
     * Determine whether the user can change user roles.
     */
    public function changeRole(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view sensitive user information.
     */
    public function viewSensitiveInfo(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can activate/deactivate users.
     */
    public function toggleStatus(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return false;
        }

        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view user's orders.
     */
    public function viewOrders(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can view user's payment history.
     */
    public function viewPayments(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can manage institutional accounts.
     */
    public function manageInstitutional(User $user): bool
    {
        return $user->isAdmin();
    }
}
