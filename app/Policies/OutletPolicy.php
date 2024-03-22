<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Outlet;
use App\Models\User;

class OutletPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any Outlet');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Outlet $Outlet): bool
    {
        return $user->can('view Outlet');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create Outlet');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Outlet $Outlet): bool
    {
        return $user->can('update Outlet');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Outlet $Outlet): bool
    {
        return $user->can('delete Outlet');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Outlet $Outlet): bool
    {
        return $user->can('restore Outlet');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Outlet $Outlet): bool
    {
        return $user->can('force-delete Outlet');
    }
}