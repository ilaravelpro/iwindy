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
        if (isset($level) && preg_match('/[0-9]/', $level)) {
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
        $data = array_merge($data, WindyPointMeta::collection($meta)->groupBy('key')->toArray());
        unset($data['created_at']);
        unset($data['updated_at']);
        return $data;
    }
}
