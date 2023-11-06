<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductFeatureId extends Model
{
    use SoftDeletes;

    protected $table = 'product_feature_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }

    public function productFeature()
    {
        return $this->hasMany(ProductFeature::class, 'id_product_feature_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
