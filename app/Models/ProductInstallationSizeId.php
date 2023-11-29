<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationSizeId extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_size_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function productInstallationSize()
    {
        return $this->hasMany(ProductInstallationSize::class, 'id_product_installation_size_id', 'id');
    }
}
