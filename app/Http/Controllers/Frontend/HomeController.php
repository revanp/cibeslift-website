<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\HeaderBanner;
use App\Models\HomeVideo;
use App\Models\Product;
use App\Models\HomeMenuSection;

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

        $products = Product::with([
            'productId',
            'productId.thumbnail'
        ])
        ->where('language_code', getLocale())
        ->whereHas('productId', function($query){
            $query->where('level', 1);
            $query->where('is_active', true);
        })
        ->get();

        $menuSection = HomeMenuSection::with([
            'homeMenuSectionId',
            'homeMenuSectionId.image'
        ])
        ->where('language_code', getLocale())
        ->whereHas('homeMenuSectionId', function($query){
            $query->where('is_active', true);
        })
        ->get();

        return view('frontend.pages.home.index', compact('headerBanner', 'video', 'products', 'menuSection'));
    }
}
