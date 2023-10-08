<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class NewsId extends Model
{
    use SoftDeletes;

    protected $table = 'news_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_news_category_id',
        'is_active',
        'is_top',
        'is_home',
        'publish_date',
        'sort',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public $timestamps = true;

    public function news()
    {
        return $this->hasMany(news::class, 'id_news_id', 'id');
    }

    public function newsCategoryId()
    {
        return $this->hasOne(NewsCategoryId::class, 'id', 'id_news_category_id');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'thumbnail');
    }
}
