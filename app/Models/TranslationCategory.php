<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationCategory extends Model
{
    protected $fillable = [
        'name',
        'file_name'
    ];

    public $timestamps = true;

    public function translationKey()
    {
        return $this->hasMany(TranslationKey::class, 'id_translation_category', 'id');
    }
}
