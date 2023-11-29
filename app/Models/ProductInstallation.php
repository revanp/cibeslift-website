<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductInstallation extends Model
{
    use SoftDeletes;

    protected $table = 'product_installation';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_installation_id',
        'name',
        'description',
        'language_code',
    ];

    public $timestamps = true;

    public function productInstallationId()
    {
        return $this->hasOne(ProductInstallationId::class, 'id', 'id_product_installation_id');
    }
}
