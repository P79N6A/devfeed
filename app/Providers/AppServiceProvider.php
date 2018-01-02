<?php

namespace Fedn\Providers;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Relation::morphMap([
            'article' => 'Fedn\Models\Article',
            'quote'   => 'Fedn\Models\Quote',
            'tag'     => 'Fedn\Models\Tag',
            'category' => 'Fedn\Models\Category',
            'user'     => 'Fedn\Models\User'
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
