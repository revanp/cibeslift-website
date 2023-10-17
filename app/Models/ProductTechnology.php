<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductTechnology extends Model
{
    use SoftDeletes;

    protected $table = 'product_technology';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_technology_id',
        'name',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productTechnologyId()
    {
        return $this->hasOne(ProductTechnologyId::class, 'id', 'id_product_technology_id');
    }
}
