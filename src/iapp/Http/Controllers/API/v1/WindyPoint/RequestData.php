<?php

namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

trait RequestData
{
    public function requestData(Request $request, $action, &$data)
    {
        if (in_array($action, ['index']) && isset($request->lat)&& isset($request->lon)){
            dd(\iLaravel\iWindy\iApp\WindyPoint::where('latitude', round($request->lat, 4))
                ->where('longitude', round($request->lon, 4))
                ->where('issued_at', '<',\Carbon\Carbon::now()->format('Y-m-d H:i:s'))->get()->toArray());
        }
    }
}
