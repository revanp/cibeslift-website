<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HomeMenuSectionId extends Model
{
    use SoftDeletes;

    protected $table = 'home_menu_section_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'url',
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function homeMenuSection()
    {
        return $this->hasMany(HomeMenuSection::class, 'id_home_menu_section_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
