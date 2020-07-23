<?php

namespace iLaravel\iWindy\iApp\Http\Resources;

use iLaravel\Core\iApp\Http\Resources\Resource;

class WindyPoint extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
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
