<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    use SoftDeletes;

    protected $table = 'nation';

    protected $fillable = [
        'id_nation_id',
        'name',
        'language_code'
    ];

    public $incrementing = true;

    public function nationId()
    {
        return $this->hasOne(NationId::class, 'id', 'id_nation_id');
    }
}
