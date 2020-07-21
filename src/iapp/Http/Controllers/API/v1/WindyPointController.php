<?php

namespace iLaravel\iWindy\Http\Controllers\API\v1;

use iLaravel\Core\iApp\Http\Controllers\API\Controller;
use iLaravel\Core\iApp\Http\Controllers\API\Methods\Controller\Index;
use iLaravel\Core\iApp\Http\Controllers\API\Methods\Controller\Show;
use iLaravel\Core\iApp\Http\Controllers\API\Methods\Controller\Store;
use iLaravel\Core\iApp\Http\Controllers\API\Methods\Controller\Update;
use iLaravel\Core\iApp\Http\Controllers\API\Methods\Controller\Destroy;


class WindyPointController extends Controller
{

    use Index,
        Show,
        Store,
        Update,
        Destroy,
        WindyPoint\RequestData,
        WindyPoint\Rules,
        WindyPoint\Fields,
        WindyPoint\Filters,
        WindyPoint\SearchQ;
}
