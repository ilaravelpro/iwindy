<?php

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
            $this->whereFirst()->where('valid_at', '<',\Carbon\Carbon::now()->subHours(3)->format('Y-m-d H:i:s'))->delete();
            if ($this->whereFirst()->where('valid_at', '<',\Carbon\Carbon::now()->addDay()->format('Y-m-d H:i:s'))->count() <= 5)
                Vendor::handelImport($params);
            if (in_array($action, ['index']) && isset($request->st)){
                $st = str_replace('/', '-', $request->st);
                if ($st > date('Y-m-d H:i:s') && $st < Carbon::now()->addDays(3)->format('Y-m-d H:i:s') && $this->whereFirst()->where('valid_at', '>', $st)->count() == 0)
                    Vendor::handelImport($params);
            }
            if (in_array($action, ['index']) && isset($request->et)){
                $et = str_replace('/', '-', $request->et);
                if ($et > date('Y-m-d H:i:s') && $et < Carbon::now()->addDays(3)->format('Y-m-d H:i:s') && $this->whereFirst()->where('valid_at', '>', $et)->count() == 0)
                    Vendor::handelImport($params);
            }
        }
    }

    protected function whereFirst() {
        $model = $this->model::where('latitude', round(\request()->lat, 4))
            ->where('longitude', round(\request()->lon, 4));
        if (isset(\request()->model))
            $model->where('model', \request()->model);
        return $model;
    }
}
