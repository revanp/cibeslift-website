<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    use SoftDeletes;

    protected $table = 'product_property';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_property_id',
        'name',
        'language_code',
    ];

    public $timestamps = true;

    public function productPropertyId()
    {
        return $this->hasOne(ProductPropertyId::class, 'id', 'id_product_property_id');
    }
}
