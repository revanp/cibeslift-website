<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class WhyCibesUspId extends Model
{
    use SoftDeletes;

    protected $table = 'why_cibes_usp_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active',
        'sort',
    ];

    public $timestamps = true;

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }

    public function whyCibesUsp()
    {
        return $this->hasMany(WhyCibesUsp::class, 'id_why_cibes_usp_id', 'id');
    }
}
