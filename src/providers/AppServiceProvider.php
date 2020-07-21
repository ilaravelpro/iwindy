<?php

namespace Avita\Aircraft\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(iwindy_path('config/iwindy.php'), 'ilaravel.windy');

        if($this->app->runningInConsole())
        {
            if (iwindy('database.migrations.include', true)) $this->loadMigrationsFrom(iwindy_path('database/migrations'));
        }
    }

    public function register()
    {
        parent::register();
    }
}
