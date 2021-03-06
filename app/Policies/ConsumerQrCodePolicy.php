<?php

namespace App\Policies;

use App\ConsumerQrCode;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsumerQrCodePolicy
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
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function userViewAny(User $user)
    {
        return $user->role === User::ROLE_USER;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\ConsumerQrCode  $consumerQrCode
     * @return mixed
     */
    public function view(User $user, ConsumerQrCode $consumerQrCode)
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
     * @param  \App\ConsumerQrCode  $consumerQrCode
     * @return mixed
     */
    public function update(User $user, ConsumerQrCode $consumerQrCode)
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
     * @param  \App\ConsumerQrCode  $consumerQrCode
     * @return mixed
     */
    public function delete(User $user, ConsumerQrCode $consumerQrCode)
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
     * @param  \App\ConsumerQrCode  $consumerQrCode
     * @return mixed
     */
    public function restore(User $user, ConsumerQrCode $consumerQrCode)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\ConsumerQrCode  $consumerQrCode
     * @return mixed
     */
    public function forceDelete(User $user, ConsumerQrCode $consumerQrCode)
    {
        //
    }
}
