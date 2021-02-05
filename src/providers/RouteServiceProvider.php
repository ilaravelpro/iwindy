<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 7/22/20, 9:55 AM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iWindy\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function register()
    {
        parent::register();
    }
    public function map(Router $router)
    {
        if (iwindy('routes.api.status', true)) $this->apiRoutes($router);
    }

    public function apiRoutes(Router $router)
    {
        $router->group([
            'namespace' => '\iLaravel\iWindy\iApp\Http\Controllers\API',
            'prefix' => 'api',
            'middleware' => 'api'
        ], function ($router) {
            require_once(iwindy_path('routes/api.php'));
        });
    }
}
