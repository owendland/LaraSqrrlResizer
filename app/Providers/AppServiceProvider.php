<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
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
        Horizon::auth(
            function () {
                return true;
            }
        );

        $slack_webhook = config('horizon.slack_webhook');
        if (!empty($slack_webhook)) {
            Horizon::routeSlackNotificationsTo($slack_webhook);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production' && $this->app->environment() !== 'stage') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
