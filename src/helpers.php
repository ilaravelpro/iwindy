<?php

function iwindy_path($path = null)
{
    $path = trim($path, '/');
    return __DIR__ . ($path ? "/$path" : '');
}

function iwindy($key = null, $default = null)
{
    return iconfig('windy' . ($key ? ".$key" : ''), $default);
}

function _handelWind($request, $data, $nameValue = 'value', $conv = false)
{
    $wind_unit = $request->has('wind_unit') ? $request->wind_unit : iwindy('units.wind');
    switch ($wind_unit) {
        case 'kt':
            if ((isset($data['key']) && in_array($data['key'], ['wind_v', 'wind_u'])) || $conv) {
                $data[$nameValue] *= 1.9438444924406;
                $data['unit'] = 'kt';
            }
            break;
    }
    return $data;
}


function _handelTemp($request, $data, $nameValue = 'value', $conv = false)
{
    $temp_unit = $request->has('temp_unit') ? $request->temp_unit : iwindy('units.temp');
    switch ($temp_unit) {
        case 'c':
            if ((isset($data['key']) && in_array($data['key'], ['temp'])) || $conv) {
                $data[$nameValue] -= 272.15;
                $data['unit'] = 'c';
            }
            break;
    }
    if (isset($data['level']) && (isset($data['key']) && in_array($data['key'], ['temp'])) || $conv){
        $level = iwindy('values.level.h_to_ft')[$data['level']."h"];
        $data['isa'] = _toISA((float)$level, $data['value']);
    }
    return $data;
}

function _toISA($level, $temp)
{
    return round(((($level / 10) * 2) - 15) - $temp, 2);
}
