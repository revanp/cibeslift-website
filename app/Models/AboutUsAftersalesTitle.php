<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AboutUsAftersalesTitle extends Model
{
    protected $table = 'about_us_aftersales_title';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'title',
        'description',
        'language_code'
    ];

    public $timestamps = true;

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
