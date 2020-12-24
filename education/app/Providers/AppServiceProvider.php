<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // to solve the SSL secured request
        // $this->app['request']->server->set('HTTP', $this->app->environment() == 'production');
        $this->app['request']->server->set('HTTP', $this->app->environment() == 'local');
        // if (!$this->app->isLocal()) {
        //     $this->app['request']->server->set('HTTP', true);
        // }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('path.public', function() {
        //     return realpath(base_path().'../public');
        // });
    }
}
