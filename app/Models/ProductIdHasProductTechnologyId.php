<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductIdHasProductTechnologyId extends Model
{
    protected $table = 'product_id_has_product_technology_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'id_product_technology_id',
    ];

    public $timestamps = false;

    public function productId()
    {
        return $this->hasMany(ProductId::class, 'id', 'id_product_id');
    }

    public function productTechonologyId()
    {
        return $this->hasMany(ProductTechonologyId::class, 'id', 'id_product_technology_id');
    }
}
