<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategoryId;
use App\Models\NewsCategory;
use App\Models\NewsId;
use App\Models\Media;
use App\Models\News;

class BlogController extends Controller
{
    public function index()
    {
        $item = News::select(
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
        )
        ->with([
            'newsId:id,publish_date',
            'newsId.thumbnail'
        ])
        ->where('language_code', getLocale())
        ->orderBy('created_at','desc')
        ->paginate(9);

        return view('frontend.pages.blog.index', compact('item'));
    }

    public function detail($country, $slug)
    {
        $data = News::select(
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
        )
        ->where('slug', $slug)
        ->get()
        ->first();

        return view('frontend.pages.blog.detail', compact('data'));
    }
}
