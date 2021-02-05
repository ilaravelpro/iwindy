<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 8/4/20, 10:07 AM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iWindy\iApp\Http\Resources;

use iLaravel\Core\iApp\Http\Resources\Resource;

class WindyPointMeta extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data = _handelWind($request, $data);
        $data = _handelTemp($request, $data);
        if ($data['level'] == 0) $data['level'] = 'surface';
        unset($data['id']);
        unset($data['id_text']);
        unset($data['key']);
        unset($data['point_id']);
        unset($data['created_at']);
        unset($data['updated_at']);
        return $data;
    }
}
