<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 1/29/21, 6:14 PM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

trait Rules
{
    public function rules(Request $request, $action, $parent = null, $unique = null)
    {
        $rules = [];
        switch ($action) {
            case 'store':
            case 'update':
                $rules = [
                    'latitude' => "required|regex:/[0-9.]*/",
                    'longitude' => "required|regex:/[0-9.]*/",
                    'valid_at' => "required|date_format:Y-m-d H:i:s",
                    'model' => "nullable|in:arome,iconEu,gfs,wavewatch,namConus,namHawaii,namAlaska,geos5",
                ];
                break;
        }
        $unique = $request->has('unique') ? $request->unique : $unique;
        if ($unique) return str_replace(['required'], ['nullable'], _get_value($rules, $unique, 'nullable|string'));
        return $rules;
    }
}
