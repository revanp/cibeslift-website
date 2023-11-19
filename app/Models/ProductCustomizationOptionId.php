<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationOptionId extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization_option_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_customization_id',
        'parent_id',
        'have_a_child',
        'level',
    ];

    public $timestamps = true;

    public function productCustomizationId()
    {
        return $this->hasOne(ProductCustomizationId::class, 'id', 'id_product_customization_id');
    }

    public function parent()
    {
        return $this->hasOne(ProductCustomizationOptionId::class, 'id', 'parent_id');
    }

    public function productCustomizationOption()
    {
        return $this->hasMany(ProductCustomizationOption::class, 'id_product_customization_option_id', 'id');
    }

    public function productCustomizationOptionVariationId()
    {
        return $this->hasMany(ProductCustomizationOptionVariationId::class, 'id_product_customization_option_id', 'id');
    }
}
