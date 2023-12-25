<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AboutUsHighlight extends Model
{
    use SoftDeletes;

    protected $table = 'about_us_highlight';

    protected $fillable = [
        'id_about_us_highlight_id',
        'name',
        'description',
        'language_code'
    ];

    public $incrementing = true;

    public function aboutUsHighlightId()
    {
        return $this->hasOne(AboutUsHighlightId::class, 'id', 'id_about_us_highlight_id');
    }
}
