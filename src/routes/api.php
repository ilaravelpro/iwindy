<?php

use Illuminate\Support\Facades\DB;

Route::namespace('v1')->prefix('v1/windy')->middleware('auth:api')->group(function () {
    Route::apiResource('points', 'WindyPointController', ['as' => 'api.windy']);
});
Route::namespace('v1')->prefix('v1/windy/test')->group(function () {
    Route::get('/', function () {
        \iLaravel\iWindy\iApp\WindyPoint::resetRecordsId();
        $data = \iLaravel\iWindy\Vendor\WindyPoint::handelImport();

    });
});
