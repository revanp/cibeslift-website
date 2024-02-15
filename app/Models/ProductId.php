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
        'parent_id',
        'product_summary_type',
        'level',
        'have_a_child',
        'sort',
        'video_url',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productSpecification()
    {
        return $this->hasOne(ProductSpecification::class, 'id_product_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product_id', 'id');
    }

    public function child()
    {
        return $this->hasMany(ProductId::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(ProductId::class, 'id', 'parent_id');
    }

    public function productUspId()
    {
        return $this->hasMany(ProductUspId::class, 'id_product_id', 'id');
    }

    public function productHighlightId()
    {
        return $this->hasMany(ProductHighlightId::class, 'id_product_id', 'id');
    }

    public function productFeatureId()
    {
        return $this->hasMany(ProductFeatureId::class, 'id_product_id', 'id');
    }

    public function productIdHasProductTechnologyId()
    {
        return $this->hasMany(ProductIdHasProductTechnologyId::class, 'id_product_id', 'id');
    }

    public function productIdHasFaqId()
    {
        return $this->hasMany(ProductIdHasFaqId::class, 'id_product_id', 'id');
    }

    public function productCustomizationId()
    {
        return $this->hasMany(ProductCustomizationId::class, 'id_product_id', 'id');
    }

    public function banner()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'banner');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'thumbnail');
    }

    public function menuIcon()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'menu_icon');
    }

    public function productSummaryImage()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'product_summary_image');
    }

    public function specificationImage()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'specification_image');
    }
}
