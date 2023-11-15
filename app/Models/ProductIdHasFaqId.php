<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIdHasFaqId extends Model
{
    protected $table = 'product_id_has_faq_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'id_faq_id',
    ];

    public $timestamps = false;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }

    public function faqId()
    {
        return $this->hasOne(FaqId::class, 'id', 'id_faq_id');
    }
}
