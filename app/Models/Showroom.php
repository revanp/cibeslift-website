<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use SoftDeletes;

    protected $table = 'showroom';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'name',
        'address',
        'google_maps_link',
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
