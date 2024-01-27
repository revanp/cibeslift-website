<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductEuropeanStandard extends Model
{
    use SoftDeletes;

    protected $table = 'product_european_standard';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_european_standard_id',
        'name',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productEuropeanStandardId()
    {
        return $this->hasOne(ProductEuropeanStandardId::class, 'id', 'id_product_european_standard_id');
    }
}
