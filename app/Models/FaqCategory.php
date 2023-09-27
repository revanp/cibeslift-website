<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    use SoftDeletes;

    protected $table = 'faq_category';

    protected $fillable = [
        'id_faq_category_id',
        'name',
        'description',
        'language_code',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $incrementing = true;

    public function faqCategoryId()
    {
        return $this->hasOne(FaqCategoryId::class, 'id', 'id_faq_category_id');
    }

    public function faq()
    {
        return $this->hasOne(Faq::class, 'id_faq_id', 'id');
    }
}
