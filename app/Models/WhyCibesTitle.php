<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhyCibesTitle extends Model
{
    protected $table = 'why_cibes_title';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'title',
        'description',
        'language_code'
    ];

    public $timestamps = true;

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
