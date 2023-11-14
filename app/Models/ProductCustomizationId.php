<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationId extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
    ];

    public $timestamps = true;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }

    public function productCustomization()
    {
        return $this->hasMany(ProductCustomization::class, 'id_product_customization_id', 'id');
    }

    public function productCustomizationFeatureId()
    {
        return $this->hasMany(ProductCustomizationFeatureId::class, 'id_product_customization_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
