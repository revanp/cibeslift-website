<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HeaderBanner extends Model
{
    use SoftDeletes;

    protected $table = 'header_banner';

    protected $fillable = [
        'id_header_banner_id',
        'title',
        'description',
        'cta',
        'link',
        'language_code',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $incrementing = true;

    public function headerBannerId()
    {
        return $this->hasOne(HeaderBannerId::class, 'id', 'id_header_banner_id');
    }
}
