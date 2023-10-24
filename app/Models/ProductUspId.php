<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductUspId extends Model
{
    use SoftDeletes;

    protected $table = 'product_usp_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
    ];

    public $timestamps = true;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }

    public function productUsp()
    {
        return $this->hasMany(ProductUsp::class, 'id_product_usp_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
