<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HeaderBannerId extends Model
{
    use SoftDeletes;

    protected $table = 'header_banner_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active',
        'image'
    ];

    public $timestamps = true;

    public function headerBanner()
    {
        return $this->hasMany(HeaderBanner::class, 'id_header_banner_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
