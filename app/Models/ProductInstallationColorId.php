<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationColorId extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_color_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function productInstallationColor()
    {
        return $this->hasMany(ProductInstallationColor::class, 'id_product_installation_color_id', 'id');
    }
}
