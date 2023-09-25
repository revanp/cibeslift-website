<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use SoftDeletes;

    protected $table = 'page';

    protected $fillable = [
        'id_page_id',
        'name',
        'language_code',
    ];

    public $incrementing = true;

    public function pageId()
    {
        return $this->hasOne(PageId::class, 'id', 'id_page_id');
    }
}
