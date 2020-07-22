<?php

namespace iLaravel\iWindy\iApp\Http\Resources;

use iLaravel\Core\iApp\Http\Resources\Resource;

class WindyPoint extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data = array_merge($data, WindyPointMeta::collection($this->meta)->groupBy('key')->toArray());
        unset($data['created_at']);
        unset($data['updated_at']);
        return $data;
    }
}
