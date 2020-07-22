<?php

namespace iLaravel\iWindy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WindyPointMeta extends Model
{
    use \iLaravel\Core\iApp\Modals\Modal;

    public static $s_prefix = 'iwpm';
    public static $s_start = 1155;
    public static $s_end = 1733270554752;

    protected $guarded = [];


    protected static function boot(){
        parent::boot();
        static::deleting(function(self $event)
        {
        });
    }

    public function tearDown()
    {
        $maxId = DB::table('windy_point_meta')->max('id');
        DB::statement('ALTER TABLE windy_point_meta AUTO_INCREMENT=' . intval($maxId + 1) . ';');
        parent::tearDown();
    }
}
