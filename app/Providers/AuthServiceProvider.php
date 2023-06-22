<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Cor;
use App\Models\Encomenda;
use App\Models\TshirtImage;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\CorPolicy;
use App\Policies\EncomendaPolicy;
use App\Policies\TshirtImagePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Encomenda::class => EncomendaPolicy::class,
        User::class => UserPolicy::class,
        TshirtImage::class => TshirtImagePolicy::class,
        Cor::class => CorPolicy::class,
        Category::class => CategoryPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Permissão apenas para clientes
        Gate::define('is-client', function($user) {
            return $user->user_type == 'C';
        });

        // Permissão apenas para administradores
        Gate::define('is-admin', function($user) {
            return $user->user_type == 'A';
        });


        // Permissão apenas para funcionarios
        Gate::define('is-funcionario', function($user) {
            return $user->user_type == 'E';
        });

        // Permissão apenas para clientes
        Gate::define('is-client-or-admin', function($user) {
            return $user->user_type != 'E';
        });
    }
}
