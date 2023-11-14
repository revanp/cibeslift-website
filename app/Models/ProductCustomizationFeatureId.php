<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationFeatureId extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization_feature_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_customization_id',
    ];

    public $timestamps = true;

    public function productCustomizationId()
    {
        return $this->hasOne(ProductCustomizationId::class, 'id', 'id_product_customization_id');
    }

    public function productCustomizationFeature()
    {
        return $this->hasMany(ProductCustomizationFeature::class, 'id_product_customization_feature_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
