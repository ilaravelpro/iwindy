<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 10/24/20, 9:37 PM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iWindy\iApp\Http\Resources;

use iLaravel\Core\iApp\Http\Resources\Resource;

class WindyPoint extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        if (isset($request->level)) {
            $wind_unit = $request->has('level_unit') ? $request->level_unit : iwindy('units.level');
            switch ($wind_unit) {
                case 'ft':
                    $level = getClosestKey($request->level, iwindy('values.level.h_to_ft'));
                    $level = substr($level, -1, 1) == 'h' ? substr($level, 0, -1) : $level;
                    break;
            }
        }
        if (method_exists($this, 'meta') && isset($level) && preg_match('/[0-9]/', $level)) {
            $first = $this->meta()
                ->selectRaw("*, ABS(level -  {$level}) AS distance")
                ->where('level', '>=', $level)
                ->orderBy('level')
                ->limit(6);
            $meta = $this->meta()
                ->selectRaw("*, ABS(level -  {$level}) AS distance")
                ->where('level', '>=', $level)
                ->orderBy('level', 'desc')
                ->limit(6)
                ->union($first)
                ->orderBy('distance')
                ->get();
        } else
            $meta = isset($this->meta) ? $this->meta : collect();
        if (!isset($level))
            $level = 0;
        $data = array_merge($data, WindyPointMeta::collection($meta)->groupBy('key')->map(function ($item) use ($request, $wind_unit, $level) {
            return $item->map(function ($item) use ($request) {
                return $item->toArray($request);
            })->filter(function ($v, $i) use ($wind_unit, $level){
                return $wind_unit == 'ft' && $level != 0 ? $level == $v['level'] : true;
            })->first();
        })->toArray($request));
        if (isset($data['wind_u'])){
            $wind = _uv2ddff($data['wind_u']['value'] / 1.9438444924406, $data['wind_v']['value'] / 1.9438444924406);
            $wind['level'] = $data['wind_u']['level'] == 0 ? 'surface' : $data['wind_u']['level'];
            $data['wind'] = _handelWind($request, $wind, 'speed', true);
            $data = insert_into_array($data, 'valid_at', 'wind', $data['wind']);
        }
        unset($data['created_at']);
        unset($data['updated_at']);
        return $data;
    }

    public function windDir($u, $v)
    {
        if ($u > 0) return ((180 / pi()) * atan($u / $v) + 180);
        if ($u < 0 & $v < 0) return ((180 / pi()) * atan($u / $v) + 0);
        if ($u > 0 & $v < 0) return ((180 / pi()) * atan($u / $v) + 360);
    }
}
