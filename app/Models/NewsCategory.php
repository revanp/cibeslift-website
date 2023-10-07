<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;

    protected $table = 'news_category';

    protected $fillable = [
        'id_news_category_id',
        'name',
        'slug',
        'language_code',
    ];

    public $incrementing = true;

    public function newsCategoryId()
    {
        return $this->hasOne(NewsCategoryId::class, 'id', 'id_news_category_id');
    }
}
