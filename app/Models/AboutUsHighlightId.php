<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AboutUsHighlightId extends Model
{
    use SoftDeletes;

    protected $table = 'about_us_highlight_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function aboutUsHighlight()
    {
        return $this->hasMany(AboutUsHighlight::class, 'id_about_us_highlight_id', 'id');
    }

    public function icon()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'icon');
    }
}
