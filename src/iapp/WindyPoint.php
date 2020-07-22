<?php

namespace iLaravel\iWindy\iApp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WindyPoint extends Model
{
    use \iLaravel\Core\iApp\Modals\Modal;

    public static $s_prefix = 'iwp';
    public static $s_start = 1155;
    public static $s_end = 1733270554752;

    protected $guarded = [];

    protected $casts = [
        'time' => 'datetime',
    ];

    protected static function boot(){
        parent::boot();
        parent::deleting(function (self $event) {
            $event->meta()->delete();
            WindyPointMeta::resetRecordsId();
        });
    }

    public function meta() {
        return $this->hasMany(WindyPointMeta::class, 'point_id');
    }

}
