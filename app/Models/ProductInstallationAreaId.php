<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationAreaId extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_area_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function productInstallationArea()
    {
        return $this->hasMany(ProductInstallationArea::class, 'id_product_installation_area_id', 'id');
    }
}
