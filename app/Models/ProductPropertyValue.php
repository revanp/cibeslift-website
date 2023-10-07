<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductPropertyValue extends Model
{
    use SoftDeletes;

    protected $table = 'product_property_value';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'name',
        'language_code',
    ];

    public $timestamps = true;

    public function productPropertyValueId()
    {
        return $this->hasOne(ProductPropertyValueId::class, 'id', 'id_product_property_value_id');
    }
}
