<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryFeature extends Model
{
    use SoftDeletes;

    protected $table = 'product_category_feature';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_category_feature_id',
        'name',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productCategoryFeatureId()
    {
        return $this->hasOne(ProductCategoryFeatureId::class, 'id', 'id_product_category_feature_id');
    }
}
