<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // $this->definePolicies();

        // super admin
        Gate::before(function ($user, $ability) {
            return $user->isRoot() ? true: null;
        });
    }

    protected function definePolicies()
    {
        // Gate::define('user.list', 'App\Policies\RolePolicy@viewAny');
    }
}
