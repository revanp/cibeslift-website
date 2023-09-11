<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationValue extends Model
{
    protected $fillable = [
        'id_translation_key',
        'country_code',
        'language_code',
        'value',
        'created_by',
        'updated_by'
    ];

    public $timestamps = true;

    public function translationKey()
    {
        return $this->hasOne(TranslationKey::class, 'id', 'id_translation_key');
    }
}
