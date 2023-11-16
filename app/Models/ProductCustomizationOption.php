<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomizationOption extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization_option';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_customization_option_id',
        'name',
        'language_code'
    ];

    public $timestamps = true;

    public function productCustomizationOptionId()
    {
        return $this->hasOne(ProductCustomizationOptionId::class, 'id', 'id_product_customization_option_id');
    }
}
