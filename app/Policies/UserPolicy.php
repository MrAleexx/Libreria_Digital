<?php

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
        // Admin puede ver cualquier usuario, usuarios solo pueden verse a sí mismos
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
        // Admin puede actualizar cualquier usuario, usuarios solo pueden actualizarse a sí mismos
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // No permitir que un usuario se elimine a sí mismo
        if ($user->id === $model->id) {
            return false;
        }

        // Solo admin puede eliminar usuarios
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
        // No permitir auto-eliminación
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
        // No permitir cambiar el propio rol
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
        // Solo admin puede ver información sensible de otros usuarios
        // Los usuarios solo pueden ver su propia información sensible
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can activate/deactivate users.
     */
    public function toggleStatus(User $user, User $model): bool
    {
        // No permitir cambiar el propio estado
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
        // Admin puede ver órdenes de cualquier usuario, usuarios solo las propias
        return $user->isAdmin() || $user->id === $model->id;
    }

    /**
     * Determine whether the user can view user's payment history.
     */
    public function viewPayments(User $user, User $model): bool
    {
        // Información de pagos solo visible para admin y el propio usuario
        return $user->isAdmin() || $user->id === $model->id;
    }
}
