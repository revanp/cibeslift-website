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

    public function productUspId()
    {
        return $this->hasMany(ProductUspId::class, 'id_product_id', 'id');
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

    public function spesificationImage()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'spesification_image');
    }
}
