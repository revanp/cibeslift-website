<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationOptionVariation extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization_option_variation';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_customization_option_variation_id',
        'name',
        'language_code'
    ];

    public $timestamps = true;

    public function productCustomizationOptionVariationId()
    {
        return $this->hasOne(ProductCustomizationOptionVariationId::class, 'id', 'id_product_customization_option_variation_id');
    }
}
