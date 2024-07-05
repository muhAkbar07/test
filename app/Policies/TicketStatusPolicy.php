<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TicketStatus;
use App\Models\User;

class TicketStatusPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole('Pic');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('view TicketStatus');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create TicketStatus');
    }

    /**
     * Determine whether the user can update the model.
     */
    // public function update(User $user, TicketStatus $ticketstatus): bool
    // {
    //     return $user->can('update TicketStatus');
    // }

    public function update(User $user, TicketStatus $ticketstatus): bool
    {
        if ($ticketstatus->id == TicketStatus::CLOSE) {
            // Hanya Admin Unit yang boleh mengubah status 'CLOSE'
            return $user->hasRole('Admin Unit');
        }

        // Izinkan pengguna lain untuk mengubah status selain 'CLOSE'
        return $user->can('update TicketStatus');
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('delete TicketStatus');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('restore TicketStatus');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TicketStatus $ticketstatus): bool
    {
        return $user->can('force-delete TicketStatus');
    }
}