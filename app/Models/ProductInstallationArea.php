<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationArea extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_area';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_installation_area_id',
        'name',
        'language_code',
    ];

    public $timestamps = true;

    public function productInstallationAreaId()
    {
        return $this->hasOne(ProductInstallationAreaId::class, 'id', 'id_product_installation_area_id');
    }
}
