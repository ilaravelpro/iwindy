<?php

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
                    'latitude' => "required|regex:[0-9.]*",
                    'longitude' => "nullable|regex:[0-9.]*",
                    'model' => "nullable|string",
                ];
                break;
        }
        $unique = $request->has('unique') ? $request->unique : $unique;
        if ($unique) return str_replace(['required'], ['nullable'], $rules[$unique]);
        return $rules;
    }
}
