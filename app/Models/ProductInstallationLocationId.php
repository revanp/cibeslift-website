<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationLocationId extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_location_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function productInstallationLocation()
    {
        return $this->hasMany(ProductInstallationLocation::class, 'id_product_installation_location_id', 'id');
    }
}
