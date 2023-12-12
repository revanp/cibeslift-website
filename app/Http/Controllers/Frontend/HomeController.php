<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\HeaderBanner;
use App\Models\HomeVideo;

class HomeController extends Controller
{
    public function index()
    {
        $headerBanner = HeaderBanner::with([
            'headerBannerId',
            'headerBannerId.image',
        ])
        ->where('language_code', getLocale())
        ->first();

        $video = HomeVideo::with([
            'video'
        ])
        ->first();

        return view('frontend.pages.home.index', compact('headerBanner', 'video'));
    }
}
