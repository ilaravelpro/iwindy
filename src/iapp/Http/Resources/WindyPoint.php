<?php

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
            $meta = $this->meta;
        $data = array_merge($data, WindyPointMeta::collection($meta)->groupBy('key')->map(function ($item) use ($request) {
            return $item->map(function ($item) use ($request) {
                return $item->toArray($request);
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
