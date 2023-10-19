<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryCustomization extends Model
{
    use SoftDeletes;

    protected $table = 'product_category_customization';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_category_customization_id',
        'name',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productCategoryCustomizationId()
    {
        return $this->hasOne(ProductCategoryCustomizationId::class, 'id', 'id_product_category_customization_id');
    }
}
