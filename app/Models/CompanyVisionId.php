<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyVisionId extends Model
{
    use SoftDeletes;

    protected $table = 'company_vision_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'url',
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function companyVision()
    {
        return $this->hasMany(CompanyVision::class, 'id_company_vision_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
