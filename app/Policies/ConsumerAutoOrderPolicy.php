<?php

namespace App\Policies;

use App\ConsumerAutoOrder;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsumerAutoOrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if (in_array($user->role, [User::ROLE_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ConsumerAutoOrder  $consumerAutoOrder
     * @return mixed
     */
    public function view(User $user, ConsumerAutoOrder $consumerAutoOrder)
    {
        if (in_array($user->role, [User::ROLE_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if (in_array($user->role, [User::ROLE_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\ConsumerAutoOrder  $consumerAutoOrder
     * @return mixed
     */
    public function update(User $user, ConsumerAutoOrder $consumerAutoOrder)
    {
        if (in_array($user->role, [User::ROLE_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ConsumerAutoOrder  $consumerAutoOrder
     * @return mixed
     */
    public function delete(User $user, ConsumerAutoOrder $consumerAutoOrder)
    {
        if (in_array($user->role, [User::ROLE_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\ConsumerAutoOrder  $consumerAutoOrder
     * @return mixed
     */
    public function restore(User $user, ConsumerAutoOrder $consumerAutoOrder)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ConsumerAutoOrder  $consumerAutoOrder
     * @return mixed
     */
    public function forceDelete(User $user, ConsumerAutoOrder $consumerAutoOrder)
    {
        //
    }
}
