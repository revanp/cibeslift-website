<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductTechnologyId extends Model
{
    use SoftDeletes;

    protected $table = 'product_technology_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productTechnology()
    {
        return $this->hasMany(ProductTechnology::class, 'id_product_technology_id', 'id');
    }

    public function productIdHasProductTechnologyId()
    {
        return $this->hasMany(ProductIdHasProductTechnologyId::class, 'id_product_technology_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
