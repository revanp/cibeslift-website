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
        'id_product_property_id',
        'view_360_image',
        'view_360_image_2',
        'discover_video',
        'compare_link',
        'download_catalogue_link',
        'download_drawing_link_thumbnail',
        'is_top',
        'is_active',
        'sort',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function product()
    {
        return $this->hasMany(Product::class, 'id_product_id', 'id');
    }

    public function productHasProperty()
    {
        return $this->hasMany(ProductHasProperty::class, 'id_product_id', 'id');
    }
}
