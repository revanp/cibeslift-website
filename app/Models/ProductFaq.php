<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductFaq extends Model
{
    use SoftDeletes;

    protected $table = 'product_faq';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_faq_id',
        'title',
        'description',
        'language_code'
    ];

    public $timestamps = true;

    public function productFaqId()
    {
        return $this->hasOne(ProductFaqId::class, 'id', 'id_product_faq_id');
    }
}
