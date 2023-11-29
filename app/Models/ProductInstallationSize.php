<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallationSize extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation_size';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_installation_size_id',
        'name',
        'language_code',
    ];

    public $timestamps = true;

    public function productInstallationSizeId()
    {
        return $this->hasOne(ProductInstallationSizeId::class, 'id', 'id_product_installation_size_id');
    }
}
