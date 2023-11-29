<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationColor extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_color';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_installation_color_id',
        'name',
        'language_code',
    ];

    public $timestamps = true;

    public function productInstallationColorId()
    {
        return $this->hasOne(ProductInstallationColorId::class, 'id', 'id_product_installation_color_id');
    }
}
