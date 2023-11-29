<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationLocation extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_location';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_installation_location_id',
        'name',
        'language_code',
    ];

    public $timestamps = true;

    public function productInstallationLocationId()
    {
        return $this->hasOne(ProductInstallationLocationId::class, 'id', 'id_product_installation_location_id');
    }
}
