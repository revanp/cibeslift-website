<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use SoftDeletes;

    protected $table = 'product_image';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_image_id',
        'name',
        'language_code'
    ];

    public $timestamps = true;

    public function productImageId()
    {
        return $this->hasOne(ProductImageId::class, 'id', 'id_product_image_id');
    }
}
