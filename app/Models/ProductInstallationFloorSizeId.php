<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationFloorSizeId extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_floor_size_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function productInstallationFloorSize()
    {
        return $this->hasMany(ProductInstallationFloorSize::class, 'id_product_installation_floor_size_id', 'id');
    }
}
