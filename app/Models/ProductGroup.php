<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use SoftDeletes;

    protected $table = 'product_group';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_group_id',
        'name',
        'slug',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productGroupId()
    {
        return $this->hasOne(ProductGroupId::class, 'id', 'id_product_group_id');
    }
}
