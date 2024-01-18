<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\HeaderBanner;
use App\Models\HomeVideo;
use App\Models\Product;
use App\Models\HomeMenuSection;
use App\Models\WhyCibesTitle;
use App\Models\WhyCibesUspId;
use App\Models\CompanyVisionId;

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

        $whyCibesTitle = WhyCibesTitle::with([
            'image'
        ])
        ->where('language_code', getLocale())
        ->first();

        $whyCibesUsp = WhyCibesUspId::with([
            'image',
            'whyCibesUsp' => function($query){
                $query->where('language_code', getLocale());
            }
        ])
        ->where('is_active', 1)
        ->orderBy('sort')
        ->get();

        $companyVision = CompanyVisionId::with([
            'image',
            'companyVision' => function($query){
                $query->where('language_code', getLocale());
            }
        ])
        ->where('is_active', 1)
        ->orderBy('sort')
        ->get();

        return view('frontend.pages.home.index', compact('headerBanner', 'video', 'products', 'menuSection', 'whyCibesTitle', 'whyCibesUsp', 'companyVision'));
    }
}
