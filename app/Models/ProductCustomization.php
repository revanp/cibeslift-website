<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCustomization extends Model
{
    use SoftDeletes;

    protected $table = 'product_customization';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_customization_id',
        'name',
        'description',
        'language_code'
    ];

    public $timestamps = true;

    public function productCustomizationId()
    {
        return $this->hasOne(ProductCustomizationId::class, 'id', 'id_product_customization_id');
    }
}
