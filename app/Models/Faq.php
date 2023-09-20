<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use SoftDeletes;

    protected $table = 'faq';

    protected $fillable = [
        'id_faq_id',
        'title',
        'description',
        'language_code',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $incrementing = true;

    public function faqId()
    {
        return $this->hasOne(FaqId::class, 'id', 'id_faq_id');
    }
}
