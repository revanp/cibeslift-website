<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryIdHasProductTechnologyId extends Model
{
    protected $table = 'product_category_id_has_product_technology_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_category_id',
        'id_product_technology_id',
    ];

    public $timestamps = false;

    public function productCategoryId()
    {
        return $this->hasMany(ProductCategoryId::class, 'id', 'id_product_category_id');
    }

    public function productTechonologyId()
    {
        return $this->hasMany(ProductTechonologyId::class, 'id', 'id_product_technology_id');
    }
}
