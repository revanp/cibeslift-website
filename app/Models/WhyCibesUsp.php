<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class WhyCibesUsp extends Model
{
    use SoftDeletes;

    protected $table = 'why_cibes_usp';

    protected $fillable = [
        'id_why_cibes_usp_id',
        'title',
        'subtitle',
        'language_code'
    ];

    public $incrementing = true;

    public function whyCibesUspId()
    {
        return $this->hasOne(WhyCibesUspId::class, 'id', 'id_why_cibes_usp_id');
    }
}
