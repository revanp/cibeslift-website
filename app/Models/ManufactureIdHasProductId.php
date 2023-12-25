<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManufactureIdHasProductId extends Model
{
    protected $table = 'manufacture_id_has_product_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_manufacture_id',
        'id_product_id',
    ];

    public $timestamps = false;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }

    public function manufactureId()
    {
        return $this->hasOne(ManufactureId::class, 'id', 'id_manufacture_id');
    }
}
