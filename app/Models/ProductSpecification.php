<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    use SoftDeletes;

    protected $table = 'product_specification';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'size',
        'installation',
        'power_supply',
        'min_headroom',
        'drive_system',
        'max_number_of_stops',
        'door_configuration',
        'rated_load',
        'speed_max',
        'lift_pit',
        'max_travel',
        'motor_power',
    ];

    public $timestamps = true;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }
}
