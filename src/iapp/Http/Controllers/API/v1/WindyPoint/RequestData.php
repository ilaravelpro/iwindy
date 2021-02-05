<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 8/11/20, 7:42 AM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;

use Carbon\Carbon;
use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;
use iLaravel\iWindy\Vendor\WindyPoint as Vendor;

trait RequestData
{
    public function requestData(Request $request, $action, &$data)
    {
        if (in_array($action, ['index']) && isset($request->lat)&& isset($request->lon)){
            $params = [];
            if (isset($request->model)){
                $request->validate([
                    'model' => explode('|', $this->rules($request, 'store', null, 'model')),
                ]);
                $params['model'] = $request->model;
            }
            $this->whereFirst()->where('valid_at', '<',\Carbon\Carbon::now()->subHours(3)->format('Y-m-d H:i:s'))
                ->each(function ($record) {
                    $record->delete();
                });
            if ($this->whereFirst()->where('valid_at', '<',\Carbon\Carbon::now()->addDay()->format('Y-m-d H:i:s'))->count() <= 5)
                Vendor::handelImport($params);
            if (in_array($action, ['index']) && isset($request->st)){
                $st = str_replace('/', '-', $request->st);
                if ($st > date('Y-m-d H:i:s') && $st < Carbon::now()->addDays(3)->format('Y-m-d H:i:s') && $this->whereFirst()->where('valid_at', '>', $st)->count() == 0)
                    Vendor::handelImport($params);
            }
            if (in_array($action, ['index']) && isset($request->et) ||  isset($request->st)){
                $et = isset($request->et) ? str_replace('/', '-', $request->et) : Carbon::parse($st)->addDays(1)->format('Y-m-d H:i:s');
                if ($et > date('Y-m-d H:i:s') && $et < Carbon::now()->addDays(3)->format('Y-m-d H:i:s') && $this->whereFirst()->where('valid_at', '>', $et)->count() == 0)
                    Vendor::handelImport($params);
            }
        }
    }

    protected function whereFirst($lotlon = true) {
        $model = $lotlon ? $this->model::where('latitude', round(\request()->lat, 4))
            ->where('longitude', round(\request()->lon, 4)) : $this->model::where('id', '>', 0);
        if (isset(\request()->model))
            $model->where('model', \request()->model);
        return $model;
    }
}
