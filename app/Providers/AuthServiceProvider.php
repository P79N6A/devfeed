<?php

namespace Fedn\Providers;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Fedn\Models\Article;
use Fedn\Policies\ArticlePolicy;
use Fedn\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create-article', 'Fedn\Policies\ArticlePolicy@add');
        Gate::define('admin', function(User $user){
            return $user->inRoles([1, 2, 3]);
        });
    }


}
