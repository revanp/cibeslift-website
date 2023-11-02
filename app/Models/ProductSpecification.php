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
        'rated_load',
        'power_supply',
        'speed',
        'min_headroom',
        'lift_pit',
        'drive_system',
        'max_travel',
        'max_number_of_stops',
        'lift_controls',
        'motor_power',
        'machine_room',
        'door_configuration',
        'directive_and_standards',
    ];

    public $timestamps = true;

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }
}
