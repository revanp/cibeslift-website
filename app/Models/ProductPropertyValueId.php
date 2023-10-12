<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductPropertyValueId extends Model
{
    use SoftDeletes;

    protected $table = 'product_property_value_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_property_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productPropertyValue()
    {
        return $this->hasMany(ProductPropertyValue::class, 'id_product_property_value_id', 'id');
    }

    public function productPropertyId()
    {
        return $this->hasOne(productPropertyId::class, 'id', 'id_product_property_id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
