<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ManufactureId extends Model
{
    use SoftDeletes;

    protected $table = 'manufacture_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'location',
        'is_coming_soon',
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function manufacture()
    {
        return $this->hasMany(Manufacture::class, 'id_manufacture_id', 'id');
    }

    public function manufactureIdHasProductId()
    {
        return $this->hasMany(ManufactureIdHasProductId::class, 'id_manufacture_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }

    public function nationFlag()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'nation_flag');
    }
}
