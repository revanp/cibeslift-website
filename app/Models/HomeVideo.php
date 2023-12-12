<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HomeVideo extends Model
{
    use SoftDeletes;

    protected $table = 'home_video';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function video()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'video');
    }
}
