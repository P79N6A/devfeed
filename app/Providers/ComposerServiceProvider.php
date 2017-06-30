<?php
/**
 * Created by PhpStorm.
 * User: miyatang
 * Date: 2017/6/19
 * Time: 15:16
 */

namespace Fedn\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            ['v2017.layout'], 'Fedn\Http\ViewComposers\BaseComposer'
        );
        // Using Closure based composers...
        View::composer('dashboard', function ($view) {
            //
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}