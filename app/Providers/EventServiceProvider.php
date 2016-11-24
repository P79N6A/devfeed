<?php

namespace Fedn\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use SocialiteProviders\Manager\SocialiteWasCalled;
use Fedn\Listeners\LogSuccessfulLogin;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
      SocialiteWasCalled::class => [
        'SocialiteProviders\QQ\QqExtendSocialite@handle',
      ],
      Login::class => [
          LogSuccessfulLogin::class
      ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
