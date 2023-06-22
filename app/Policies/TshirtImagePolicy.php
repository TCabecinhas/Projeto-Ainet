<?php

namespace App\Policies;

use App\Models\TshirtImage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TshirtImagePolicy
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
     * @param  \App\Models\TshirtImage  $tshirtImage
     * @return mixed
     */
    public function view(User $user, TshirtImage $tshirtImage)
    {
        return ($user->user_type == 'A' && $tshirtImage->customer_id == NULL) || ($user->user_type == 'C' && $tshirtImage->customer_id == $user->id);
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
     * @param  \App\Models\TshirtImage  $tshirtImage
     * @return mixed
     */
    public function update(User $user, TshirtImage $tshirtImage)
    {
        return ($user->user_type == 'A' && $tshirtImage->customer_id == NULL) || ($user->id == $tshirtImage->customer_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TshirtImage  $tshirtImage
     * @return mixed
     */
    public function delete(User $user, TshirtImage $tshirtImage)
    {
        return ($user->user_type == 'A' && $tshirtImage->customer_id == NULL) || ($user->id == $tshirtImage->customer_id);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TshirtImage  $tshirtImage
     * @return mixed
     */
    public function restore(User $user, TshirtImage $tshirtImage)
    {
        return $user->user_type == 'A' && $tshirtImage->customer_id == NULL;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TshirtImage  $tshirtImage
     * @return mixed
     */
    public function forceDelete(User $user, TshirtImage $tshirtImage)
    {
        //
    }
}
