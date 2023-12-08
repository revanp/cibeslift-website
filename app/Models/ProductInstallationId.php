<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationId extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'id_product_installation_size_id',
        'id_product_installation_floor_size_id',
        'id_product_installation_area_id',
        'id_product_installation_location_id',
        'id_product_installation_color_id',
        'location',
        'number_of_stops',
        'is_active',
        'installation_date',
    ];

    public $timestamps = true;

    public function thumbnail()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'thumbnail');
    }

    public function image()
    {
        return $this->morphMany('App\Models\Media', 'mediable')->where('content_type', 'image');
    }

    public function productInstallation()
    {
        return $this->hasMany(ProductInstallation::class, 'id_product_installation_id', 'id');
    }

    public function productInstallationAreaId()
    {
        return $this->hasOne(ProductInstallationAreaId::class, 'id', 'id_product_installation_area_id');
    }

    public function productInstallationColorId()
    {
        return $this->hasOne(ProductInstallationColorId::class, 'id', 'id_product_installation_color_id');
    }

    public function productInstallationFloorSizeId()
    {
        return $this->hasOne(ProductInstallationFloorSizeId::class, 'id', 'id_product_installation_floor_size_id');
    }

    public function productInstallationLocationId()
    {
        return $this->hasOne(ProductInstallationLocationId::class, 'id', 'id_product_installation_location_id');
    }

    public function productInstallationSizeId()
    {
        return $this->hasOne(ProductInstallationSizeId::class, 'id', 'id_product_installation_size_id');
    }

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }
}
