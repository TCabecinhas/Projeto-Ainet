<?php

namespace App\Policies;

use App\Models\Cor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cor  $cor
     * @return mixed
     */
    public function view(User $user, Cor $cor)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cor  $cor
     * @return mixed
     */
    public function update(User $user, Cor $cor)
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cor  $cor
     * @return mixed
     */
    public function delete(User $user, Cor $cor)
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cor  $cor
     * @return mixed
     */
    public function restore(User $user, Cor $cor)
    {
        return $user->user_type == 'A';
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cor  $cor
     * @return mixed
     */
    public function forceDelete(User $user, Cor $cor)
    {
        //
    }
}
