<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NationId extends Model
{
    use SoftDeletes;

    protected $table = 'nation_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'link',
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function nation()
    {
        return $this->hasMany(Nation::class, 'id_nation_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
