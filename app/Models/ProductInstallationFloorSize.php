<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationFloorSize extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_floor_size';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_installation_floor_size_id',
        'name',
        'language_code',
    ];

    public $timestamps = true;

    public function productInstallationFloorSizeId()
    {
        return $this->hasOne(ProductInstallationFloorSizeId::class, 'id', 'id_product_installation_floor_size_id');
    }
}
