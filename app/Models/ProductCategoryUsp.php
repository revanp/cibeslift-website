<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryUsp extends Model
{
    use SoftDeletes;

    protected $table = 'product_category_usp';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_category_usp_id',
        'name',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productCategoryUspId()
    {
        return $this->hasOne(ProductCategoryUspId::class, 'id', 'id_product_category_usp_id');
    }
}
