<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use SoftDeletes;

    protected $table = 'manufacture';

    protected $fillable = [
        'id_manufacture_id',
        'name',
        'description',
        'language_code'
    ];

    public $incrementing = true;

    public function manufactureId()
    {
        return $this->hasOne(ManufactureId::class, 'id', 'id_manufacture_id');
    }
}
