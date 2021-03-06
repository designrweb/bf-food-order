<?php

namespace App\Policies;

use App\Consumer;
use App\Services\UserService;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsumerPolicy
{
    use HandlesAuthorization;

    /**
     * @var UserService
     */
    public $userService;

    /**
     * ConsumerPolicy constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if (in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can view user side of consumers.
     *
     * @param \App\User $user
     * @return bool
     */
    public function userViewAny(User $user)
    {
        return $user->role === User::ROLE_USER;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\User     $user
     * @param \App\Consumer $consumer
     * @return mixed
     */
    public function view(User $user, Consumer $consumer)
    {
        if (in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        if (in_array($user->role, [User::ROLE_USER]) && $this->userService->isCompletedProfile()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function update(User $user)
    {
        if (in_array($user->role, [User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\User     $user
     * @param \App\Consumer $consumer
     * @return mixed
     */
    public function delete(User $user, Consumer $consumer)
    {
        if (in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_USER])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\User     $user
     * @param \App\Consumer $consumer
     * @return mixed
     */
    public function restore(User $user, Consumer $consumer)
    {
        if (in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_USER])) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\User     $user
     * @param \App\Consumer $consumer
     * @return mixed
     */
    public function forceDelete(User $user, Consumer $consumer)
    {
        if (in_array($user->role, [User::ROLE_SUPER_ADMIN, User::ROLE_USER])) {
            return true;
        }

        return false;
    }
}
