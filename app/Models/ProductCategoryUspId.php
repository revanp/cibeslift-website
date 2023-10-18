<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryUspId extends Model
{
    use SoftDeletes;

    protected $table = 'product_category_usp_id';

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

    public function productCategoryUsp()
    {
        return $this->hasMany(ProductCategoryUsp::class, 'id_product_category_usp_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
