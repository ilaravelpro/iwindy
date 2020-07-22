<?php

namespace iLaravel\iWindy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WindyPoint extends Model
{
    use \iLaravel\Core\iApp\Modals\Modal,
        \iLaravel\Core\iApp\Modals\Metable;

    public static $s_prefix = 'iwp';
    public static $s_start = 1155;
    public static $s_end = 1733270554752;

    protected $guarded = [];

    protected $casts = [
        'time' => 'timestamp',
    ];

    protected static function boot(){
        parent::boot();
    }

    public function tearDown()
    {
        $maxId = DB::table('windy_points')->max('id');
        DB::statement('ALTER TABLE windy_points AUTO_INCREMENT=' . intval($maxId + 1) . ';');
        parent::tearDown();
    }

}
