<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 10/12/20, 11:02 PM
 * Copyright (c) 2021. Powered by iamir.net
 */

Route::namespace('v1')->prefix('v1/windy')->middleware('auth:api')->group(function () {
    Route::apiResource('points', 'WindyPointController', ['as' => 'api.windy','except' => ['store','update','destroy']]);
});
