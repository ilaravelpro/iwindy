<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 7/21/20, 9:10 PM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iWindy\Providers;

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
