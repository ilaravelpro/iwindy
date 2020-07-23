<?php

namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

trait FilterWithValidAt
{
    public function filterWithValidAt(Request $request, $model, $parent = null, $filters = [], $operators = [])
    {
        $start_time = $request->has('st') ? str_replace('/', '-', $request->st) : \Carbon\Carbon::now()->subHours(3)->format('Y-m-d H:i:s');
        $end_time = $request->has('et') ? str_replace('/', '-', $request->et) : \Carbon\Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $request->validate([
            'st' => explode('|', $this->rules($request, 'store', null, 'valid_at')),
            'et' => explode('|', $this->rules($request, 'store', null, 'valid_at')),
        ]);
        $model->where('valid_at', '>', $start_time)
            ->where('valid_at', '<', $end_time);
    }
}
