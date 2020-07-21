<?php

namespace iLaravel\iWindy\Http\Controllers\API\v1\WindyPoint;

use iLaravel\Core\iApp\Http\Requests\iLaravel as Request;

trait Rules
{
    public function rules(Request $request, $action, $aircraft = null, $unique = null)
    {
        $rules = [];
        switch ($action) {
            case 'store':
            case 'update':
                $rules = [
                    'client_id' => "required",
                    'type' => "nullable|string|max:255|regex:/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/",
                    'model' => "nullable|regex:/^[A-Za-z0-9]{0,3}$/",
                    'series' => "nullable|regex:/^[0-9]{0,3}$/",
                    'registration' => "required|string|max:255|regex:/^[a-zA-Z0-9]+(([',. -][a-zA-Z ])?[a-zA-Z0-9]*)*$/",
                    'number' => "nullable|regex:/^[A-Za-z0-9]{0,8}$/",
                    'unit' => "required|in:kgs,lbs",
                    'mrw' => "nullable|regex:/^[0-9]{0,6}$/",
                    'mtow' => "nullable|regex:/^[0-9]{0,6}$/",
                    'mzfw' => "nullable|regex:/^[0-9]{0,6}$/",
                    'mlw' => "nullable|regex:/^[0-9]{0,6}$/",
                    'bew' => "nullable|regex:/^[0-9]{0,6}$/",
                    'bewh' => "nullable|regex:/^[0-9]{1,5}(\.\d{1,2})?$/",
                    'mpc' => "nullable|regex:/^[0-9]{0,6}$/",
                    'mfc' => "nullable|regex:/^[0-9]{0,6}$/",
                    'fuel_density' => "nullable",
                ];
                if ($aircraft == null || (isset($aircraft->registration) && $aircraft->registration != $request->registration)) $rules['registration'] .= '|unique:aircrafts,registration';
                break;
        }
        $unique = $request->has('unique') ? $request->unique : $unique;
        if ($unique) return str_replace(['required'], ['nullable'], $rules[$unique]);
        return $rules;
    }
}
