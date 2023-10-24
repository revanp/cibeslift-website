<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductUsp extends Model
{
    use SoftDeletes;

    protected $table = 'product_usp';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_usp_id',
        'name',
        'description',
        'language_code'
    ];

    public $timestamps = true;

    public function productUspId()
    {
        return $this->hasOne(ProductUspId::class, 'id', 'id_product_usp_id');
    }
}
