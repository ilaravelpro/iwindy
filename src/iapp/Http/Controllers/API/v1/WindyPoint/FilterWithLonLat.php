<?php

namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;

trait FilterWithLonLat
{
    public function filterWithLonLat($request, $model, $parent = null, $filters = [], $operators = [])
    {
        if (isset($request->lat)&& isset($request->lon)){
            $model->where('latitude', round($request->lat, 4))
                ->where('longitude', round($request->lon, 4));
        }
        $model->where('issued_at', '>',\Carbon\Carbon::now()->subHours(3)->format('Y-m-d H:i:s'))
            ->where('issued_at', '<',\Carbon\Carbon::now()->addDay()->format('Y-m-d H:i:s'));
    }
}
