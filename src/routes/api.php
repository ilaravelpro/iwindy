<?php

Route::namespace('v1')->prefix('v1/windy')->middleware('auth:api')->group(function () {
    Route::apiResource('windy/points', 'WindyPointController', ['as' => 'api.windy']);
});
