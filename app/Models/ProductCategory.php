<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $table = 'product_category';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'page_title',
        'seo_title',
        'seo_description',
        'seo_keyword',
        'seo_canonical_url',
        'language_code',
    ];

    public $timestamps = true;

    public function productCategoryId()
    {
        return $this->hasOne(ProductCategoryId::class, 'id', 'id_product_category_id');
    }
}
