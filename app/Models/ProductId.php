<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductId extends Model
{
    use SoftDeletes;

    protected $table = 'product_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_category_id',
        'sort',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productCategoryId()
    {
        return $this->hasOne(ProductCategoryId::class, 'id', 'id_product_category_id');
    }

    public function productSpecification()
    {
        return $this->hasOne(ProductSpecification::class, 'id_product_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product_id', 'id');
    }

    public function productImageId()
    {
        return $this->hasMany(ProductImageId::class, 'id_product_id', 'id');
    }

    public function banner()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'banner');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'thumbnail');
    }

    public function spesificationImage()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'spesification_image');
    }
}
