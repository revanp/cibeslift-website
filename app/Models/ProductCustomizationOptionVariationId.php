<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationOptionVariationId extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization_option_variation_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_customization_option_id'
    ];

    public $timestamps = true;

    public function productCustomizationOptionId()
    {
        return $this->hasOne(ProductCustomizationOptionId::class, 'id', 'id_product_customization_option_id');
    }

    public function productCustomizationOptionVariation()
    {
        return $this->hasMany(ProductCustomizationOptionVariation::class, 'id_product_customization_option_variation_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
