<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductFaqId extends Model
{
    use SoftDeletes;

    protected $table = 'product_faq_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'is_active'
    ];

    public $timestamps = true;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }

    public function productFaq()
    {
        return $this->hasMany(ProductFaq::class, 'id_product_faq_id', 'id');
    }
}
