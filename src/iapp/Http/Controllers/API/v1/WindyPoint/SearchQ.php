<?php


namespace iLaravel\iWindy\Http\Controllers\API\v1\WindyPoint;


trait SearchQ
{
    public function searchQ($request, $model, $parent)
    {
        $q = $request->q;
        $model->where(function ($query) use ($q) {
            $query->where('aircrafts.type', 'LIKE', "%$q%")
                ->orWhere('aircrafts.model', 'LIKE', "%$q%")
                ->orWhere('aircrafts.registration', 'LIKE', "%$q%");
        });
    }
}
