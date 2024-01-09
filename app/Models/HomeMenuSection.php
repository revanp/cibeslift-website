<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HomeMenuSection extends Model
{
    use SoftDeletes;

    protected $table = 'home_menu_section';

    protected $fillable = [
        'id_home_menu_section_id',
        'title',
        'description',
        'cta',
        'language_code'
    ];

    public $incrementing = true;

    public function homeMenuSectionId()
    {
        return $this->hasOne(HomeMenuSectionId::class, 'id', 'id_home_menu_section_id');
    }
}
