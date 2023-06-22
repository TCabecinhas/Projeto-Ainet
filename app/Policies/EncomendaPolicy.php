<?php

namespace App\Policies;

use App\Models\Encomenda;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EncomendaPolicy
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

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Encomenda  $encomenda
     * @return mixed
     */
    public function view(User $user, Encomenda $encomenda)
    {
        return $user->tipo->admin || $encomenda->cliente_id == $user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->tipo == 'C';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Encomenda  $encomenda
     * @return mixed
     */
    public function update(User $user, Encomenda $encomenda)
    {
        return $user->tipo != 'C' && $encomenda->estado != 'fechada';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Encomenda  $encomenda
     * @return mixed
     */
    public function delete(User $user, Encomenda $encomenda)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Encomenda  $encomenda
     * @return mixed
     */
    public function restore(User $user, Encomenda $encomenda)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Encomenda  $encomenda
     * @return mixed
     */
    public function forceDelete(User $user, Encomenda $encomenda)
    {
        //
    }

    public function pay(User $user, Encomenda $encomenda){
        return ($user->tipo == 'A' || $user->tipo == 'E') && $encomenda->estado == 'pendente';
    }

    public function close(User $user, Encomenda $encomenda){
        return ($user->tipo == 'A' || $user->tipo == 'E') && $encomenda->estado == 'paga';
    }

    public function cancel(User $user, Encomenda $encomenda){
        return $user->tipo == 'A' && $encomenda->estado != 'anulada';
    }

    public function recibo(User $user, Encomenda $encomenda){
        return $user->tipo == 'A' || ($encomenda->cliente_id == $user->id);
    }
}
