<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AboutUsAftersalesId extends Model
{
    use SoftDeletes;

    protected $table = 'about_us_aftersales_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function aboutUsAftersales()
    {
        return $this->hasMany(AboutUsAftersales::class, 'id_about_us_aftersales_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
