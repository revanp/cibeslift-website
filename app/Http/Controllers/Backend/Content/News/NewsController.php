<?php

namespace App\Http\Controllers\Backend\Content\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategoryId;
use App\Models\NewsCategory;
use App\Models\NewsId;
use App\Models\News;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('backend.pages.content.news.news.index');
    }

    public function create()
    {
        $categories = NewsCategory::where('language_code', 'id')->get();

        return view('backend.pages.content.news.news.create', compact('categories'));
    }
}
