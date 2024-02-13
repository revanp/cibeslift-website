<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AboutUsBanner extends Model
{
    use SoftDeletes;

    protected $table = 'about_us_banner';

    protected $fillable = [
        'id_about_us_banner_id',
        'title',
        'description',
        'language_code'
    ];

    public $incrementing = true;

    public function aboutUsBannerId()
    {
        return $this->hasOne(AboutUsBannerId::class, 'id', 'id_about_us_banner_id');
    }
}
