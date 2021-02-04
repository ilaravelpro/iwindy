<?php


namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;


trait Filters
{
    public function filters($request, $model, $parent = null, $operators = [])
    {
        $current = [];
        $filters = [
            [
                'name' => 'all',
                'title' => _t('all'),
                'type' => 'text',
            ],
            [
                'name' => 'type',
                'title' => _t('type'),
                'type' => 'text'
            ],
            [
                'name' => 'model',
                'title' => _t('model'),
                'type' => 'text'
            ],
            [
                'name' => 'registration',
                'title' => _t('registration'),
                'type' => 'text'
            ],
        ];
        $this->filterWithLonLat($request, $model, $parent, $filters, $operators);
        $this->filterWithValidAt($request, $model, $parent, $filters, $operators);
        return [$filters, $current, $operators];
    }
}
