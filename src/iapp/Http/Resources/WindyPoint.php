<?php

namespace iLaravel\iWindy\iApp\Http\Resources;

use iLaravel\Core\iApp\Http\Resources\Resource;

class WindyPoint extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        if (isset($request->level)){
            $wind_unit = $request->has('level_unit') ? $request->level_unit : iwindy('units.level');
            switch ($wind_unit){
                case 'ft':
                    $level = array_keys(iwindy('values.level.h_to_ft'))[getClosestKey($request->level , array_values(iwindy('values.level.h_to_ft')))];
                    $request->merge(['level' => substr($level, -1, 1) == 'h' ? substr($level , 0, -1) : $level]);
                    break;
            }
        }
        if (isset($request->level) && preg_match('/[0-9]/', $request->level)){
            $first = $this->meta()
                ->selectRaw("*, ABS(level -  {$request->level}) AS distance")
                ->where('level', '>=', $request->level)
                ->orderBy('level')
                ->limit(6);
            $meta = $this->meta()
                ->selectRaw("*, ABS(level -  {$request->level}) AS distance")
                ->where(function ($query) use ($request) {
                    $query ->where('level', '>=', $request->level)
                        ->orWhere('level', 'surface');
                })
                ->orderBy('level', 'desc')
                ->limit(6)
                ->union($first)
                ->orderBy('distance')
                ->get();
        }elseif (isset($request->level) && preg_match('/[a-zA-Z]/', $request->level))
            $meta = $this->meta->where('level', $request->level);
        else
            $meta = $this->meta;
        $data = array_merge($data, WindyPointMeta::collection($meta)->groupBy('key')->toArray());
        unset($data['created_at']);
        unset($data['updated_at']);
        return $data;
    }
}
