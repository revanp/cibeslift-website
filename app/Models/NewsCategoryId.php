<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NewsCategoryId extends Model
{
    use SoftDeletes;

    protected $table = 'news_category_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'is_active',
        'sort',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function newsCategory()
    {
        return $this->hasMany(NewsCategory::class, 'id_news_category_id', 'id');
    }
}
