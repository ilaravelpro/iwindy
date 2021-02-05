<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 12/20/20, 11:09 AM
 * Copyright (c) 2021. Powered by iamir.net
 */

namespace iLaravel\iWindy\iApp;

use iLaravel\Core\iApp\Methods\MetaData;
use Illuminate\Support\Facades\DB;

class WindyPointMeta extends MetaData
{
    use \iLaravel\Core\iApp\Modals\Modal;

    public static $s_prefix = 'IWPM';
    public static $s_start = 1155;
    public static $s_end = 1733270554752;

    protected $table = 'windy_points_meta';

    protected $guarded = [];

}
