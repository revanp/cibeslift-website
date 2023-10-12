<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductPropertyId extends Model
{
    use SoftDeletes;

    protected $table = 'product_property_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'sort',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productProperty()
    {
        return $this->hasMany(ProductProperty::class, 'id_product_property_id', 'id');
    }

    public function productPropertyValueId()
    {
        return $this->hasMany(ProductPropertyValueId::class, 'id_product_property_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
