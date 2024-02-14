<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AboutUsAftersales extends Model
{
    use SoftDeletes;

    protected $table = 'about_us_aftersales';

    protected $fillable = [
        'id_about_us_aftersales_id',
        'name',
        'description',
        'language_code'
    ];

    public $incrementing = true;

    public function aboutUsAftersalesId()
    {
        return $this->hasOne(AboutUsAftersalesId::class, 'id', 'id_about_us_aftersales_id');
    }
}
