<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PageId extends Model
{
    use SoftDeletes;

    protected $table = 'page_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'slug',
        'is_active'
    ];

    public $timestamps = true;

    public function page()
    {
        return $this->hasMany(Page::class, 'id_page_id', 'id');
    }
}
