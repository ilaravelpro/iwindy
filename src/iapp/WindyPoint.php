<?php

namespace iLaravel\iWindy\iApp;

use Illuminate\Database\Eloquent\Model;

class WindyPoint extends Model
{
    use \iLaravel\Core\iApp\Modals\Modal;

    public static $s_prefix = 'IWP';
    public static $s_start = 1155;
    public static $s_end = 1733270554752;

    protected $guarded = [];

    protected $casts = [
        'valid_at' => 'datetime',
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

    public function getValidAtAttribute($value)
    {
        return format_datetime($value, $this->datetime, 'time');
    }

}
