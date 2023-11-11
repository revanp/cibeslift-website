<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'product';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'name',
        'slug',
        'short_description',
        'description',
        'video_description',
        'page_title',
        'seo_title',
        'seo_description',
        'seo_keyword',
        'seo_canonical_url',
        'language_code',
    ];

    public $timestamps = true;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }
}
