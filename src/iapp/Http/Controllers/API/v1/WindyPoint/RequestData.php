<?php

namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;
use iLaravel\iWindy\iApp\WindyPoint;

trait RequestData
{
    public function requestData(Request $request, $action, &$data)
    {
        if (in_array($action, ['index']) && isset($request->lat)&& isset($request->lon)){
            WindyPoint::where('latitude', round($request->lat, 4))
                ->where('longitude', round($request->lon, 4))
                ->where('issued_at', '<',\Carbon\Carbon::now()->subHours(3)->format('Y-m-d H:i:s'))->delete();
            if (WindyPoint::where('latitude', round($request->lat, 4))
                ->where('longitude', round($request->lon, 4))
                ->where('issued_at', '<',\Carbon\Carbon::now()->addDay()->format('Y-m-d H:i:s'))->count() <= 5) {
                \iLaravel\iWindy\Vendor\WindyPoint::handelImport();
            }
        }
    }
}
