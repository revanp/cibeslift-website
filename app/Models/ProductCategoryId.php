<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryId extends Model
{
    use SoftDeletes;

    protected $table = 'product_category_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'product_summary_type',
        'sort',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class, 'id_product_category_id', 'id');
    }

    public function productCategoryFeatureId()
    {
        return $this->hasMany(ProductCategoryFeatureId::class, 'id_product_category_id', 'id');
    }

    public function productCategoryUspId()
    {
        return $this->hasMany(ProductCategoryUspId::class, 'id_product_category_id', 'id');
    }

    public function productCategoryCustomizationId()
    {
        return $this->hasMany(ProductCategoryCustomizationId::class, 'id_product_category_id', 'id');
    }

    public function productCategoryIdHasProductTechnologyId()
    {
        return $this->hasMany(ProductCategoryIdHasProductTechnologyId::class, 'id_product_category_id', 'id');
    }

    public function productId()
    {
        return $this->hasMany(ProductId::class, 'id_product_category_id', 'id');
    }

    public function banner()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'banner');
    }

    public function menuIcon()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'menu_icon');
    }

    public function productSummaryImage()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'product_summary_image');
    }
}
