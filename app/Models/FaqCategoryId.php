<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FaqCategoryId extends Model
{
    use SoftDeletes;

    protected $table = 'faq_category_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active'
    ];

    public $timestamps = true;

    public function faqCategory()
    {
        return $this->hasMany(FaqCategory::class, 'id_faq_category_id', 'id');
    }
}
