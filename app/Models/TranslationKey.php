<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationKey extends Model
{
    protected $fillable = [
        'id_translation_category',
        'value'
    ];

    public $timestamps = true;

    public function translationValue()
    {
        return $this->hasMany(TranslationValue::class, 'id_translation_key', 'id');
    }

    public function translationCategory()
    {
        return $this->hasOne(TranslationCategory::class, 'id', 'id_translation_category');
    }
}
