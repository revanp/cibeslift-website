<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsHighlightImage extends Model
{
    protected $table = 'about_us_highlight_image';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
