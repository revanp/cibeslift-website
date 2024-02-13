<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AboutUsBannerId extends Model
{
    use SoftDeletes;

    protected $table = 'about_us_banner_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'image'
    ];

    public $timestamps = true;

    public function aboutUsBanner()
    {
        return $this->hasMany(AboutUsBanner::class, 'id_about_us_banner_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
