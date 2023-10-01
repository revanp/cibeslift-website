<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductGroupId extends Model
{
    use SoftDeletes;

    protected $table = 'product_group_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productGroup()
    {
        return $this->hasMany(ProductGroup::class, 'id_product_group_id', 'id');
    }
}
