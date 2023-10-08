<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'id_news_id',
        'title',
        'slug',
        'description',
        'content',
        'seo_title',
        'seo_description',
        'seo_keyword',
        'seo_canonical_url',
        'language_code',

    ];

    public $incrementing = true;

    public function newsId()
    {
        return $this->hasOne(NewsId::class, 'id', 'id_news_id');
    }
}
