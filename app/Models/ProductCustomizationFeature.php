<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationFeature extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization_feature';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_customization_feature_id',
        'name',
        'description',
        'language_code'
    ];

    public $timestamps = true;

    public function productCustomizationFeatureId()
    {
        return $this->hasOne(ProductCustomizationFeatureId::class, 'id', 'id_product_customization_feature_id');
    }
}
