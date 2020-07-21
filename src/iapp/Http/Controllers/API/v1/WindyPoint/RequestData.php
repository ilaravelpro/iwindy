<?php

namespace iLaravel\iWindy\Http\Controllers\API\v1\WindyPoint;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

trait RequestData
{
    public function requestData(Request $request, $action, &$data)
    {
        if (in_array($action, ['store', 'update']) && isset($data['client_id']))
            unset($data['client']);
    }
}
