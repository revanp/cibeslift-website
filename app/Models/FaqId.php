<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class FaqId extends Model
{
    use SoftDeletes;

    protected $table = 'faq_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_faq_category_id',
        'is_active'
    ];

    public $timestamps = true;

    public function faqCategoryId()
    {
        return $this->hasOne(FaqCategoryId::class, 'id', 'id_faq_category_id');
    }

    public function faq()
    {
        return $this->hasMany(Faq::class, 'id_faq_id', 'id');
    }
}
