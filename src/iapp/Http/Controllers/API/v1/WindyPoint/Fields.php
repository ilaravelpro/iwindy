<?php

namespace iLaravel\iWindy\Http\Controllers\API\v1\WindyPoint;

use App\Client;
use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

trait Fields
{
    public function fields(Request $request, $action)
    {
        $data = [];
        $fields = array_keys($this->rules($request, 'store'));
        foreach ($fields as $value) {
            if ($request->has($value)) {
                $data[$value] = $request->$value;
            }
        }
        $data['client_id'] = Client::id($data['client_id']);
        $data['creator_id'] = auth()->id();
        return $data;
    }
}
