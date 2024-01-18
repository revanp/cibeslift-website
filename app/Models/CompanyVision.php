<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CompanyVision extends Model
{
    use SoftDeletes;

    protected $table = 'company_vision';

    protected $fillable = [
        'id_company_vision_id',
        'title',
        'description',
        'cta',
        'language_code'
    ];

    public $incrementing = true;

    public function CompanyVisionId()
    {
        return $this->hasOne(CompanyVisionId::class, 'id', 'id_company_vision_id');
    }
}
