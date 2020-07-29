<?php

namespace iLaravel\iWindy\iApp\Http\Resources;

use iLaravel\Core\iApp\Http\Resources\Resource;

class WindyPointMeta extends Resource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data = $this->handelWind($request, $data);
        $data = $this->handelTemp($request, $data);
        unset($data['id']);
        unset($data['id_text']);
        unset($data['key']);
        unset($data['point_id']);
        unset($data['created_at']);
        unset($data['updated_at']);
        return $data;
    }

    private function handelWind($request, $data) {
        $wind_unit = $request->has('wind_unit') ? $request->wind_unit : iwindy('units.wind');
        switch ($wind_unit){
            case 'kt':
                if (in_array($this->key, ['wind_v', 'wind_u'])){
                    $data['value'] *=  1.9438444924406;
                    $data['unit'] = 'kt';
                }
                break;
        }
        return $data;
    }

    private function handelTemp($request, $data) {
        $temp_unit = $request->has('temp_unit') ? $request->temp_unit : iwindy('units.temp');
        switch ($temp_unit){
            case 'c':
                if (in_array($this->key, ['temp'])){
                    $data['value'] -=  272.15;
                    $data['unit'] = 'c';
                }
                break;
        }
        return $data;
    }
}
