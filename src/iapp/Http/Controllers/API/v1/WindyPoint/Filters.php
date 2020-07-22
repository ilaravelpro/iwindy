<?php


namespace iLaravel\iWindy\iApp\Http\Controllers\API\v1\WindyPoint;


trait Filters
{
    public function filters($request, $model, $parent = null, $operators = [])
    {
        $user = auth()->user();
        $filters = [];
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
        $this->requestFilter($request, $model, $parent, $filters, $operators);
        if ($request->q) {
            $this->searchQ($request, $model, $parent);
            $current['q'] = $request->q;
        }
        $this->filterWithLonLat($request, $model, $parent, $filters, $operators);
        return [$filters, $current, $operators];
    }
}
