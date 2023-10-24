<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    use SoftDeletes;

    protected $table = 'product_feature';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_feature_id',
        'name',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productFeatureId()
    {
        return $this->hasOne(ProductFeatureId::class, 'id', 'id_product_feature_id');
    }
}
