<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryId;
use App\Models\NationId;
use App\Models\ManufactureId;
use App\Models\AboutUsHighlightImage;
use App\Models\AboutUsHighlightId;
use App\Models\Showroom;
use App\Models\Product;
use App\Models\AboutUsBanner;
use App\Models\AboutUsAftersales;
use App\Models\AboutUsAftersalesTitle;
use Illuminate\Support\Facades\Crypt;

class AboutController extends Controller
{
    public function index()
    {
        $history = HistoryId::with([
            'history' => function($query){
                $query->where('language_code', getLocale());
            },
            'image'
        ])
        ->orderBy('sort')
        ->get();

        $nation = NationId::with([
            'nation' => function($query){
                $query->where('language_code', getLocale());
            },
            'image'
        ])
        ->orderBy('sort')
        ->get();

        $manufacture = ManufactureId::with([
            'manufacture' => function($query){
                $query->where('language_code', getLocale());
            },
            'image',
            'nationFlag'
        ])
        ->orderBy('sort')
        ->get();

        $highlightImage = AboutUsHighlightImage::with('image')->first();

        $highlight = AboutUsHighlightId::with([
            'aboutUsHighlight' => function($query){
                $query->where('language_code', getLocale());
            },
            'icon'
        ])
        ->orderBy('sort')
        ->get();

        $banner = AboutUsBanner::with([
            'aboutUsBannerId',
            'aboutUsBannerId.image',
        ])
        ->where('language_code', getLocale())
        ->first();

        $showroom = Showroom::with([
            'image'
        ])
        ->orderBy('sort')
        ->get();

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

        $aftersalesTitle = AboutUsAftersalesTitle::with([
            'image'
        ])
        ->where('language_code', getLocale())
        ->first();

        $aftersales = AboutUsAftersales::with([
            'aboutUsAftersalesId',
            'aboutUsAftersalesId.image',
        ])
        ->where('language_code', getLocale())
        ->whereHas('aboutUsAftersalesId', function($query){
            $query->where('is_active', true);
        })
        ->get();

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

        return view('frontend.pages.about.index', compact('history', 'nation', 'manufacture', 'highlightImage', 'highlight', 'showroom', 'products', 'banner', 'aftersalesTitle', 'aftersales', 'products'));
    }

    public function getManufacture(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        $manufacture = ManufactureId::with([
            'manufacture' => function($query){
                $query->where('language_code', getLocale());
            },
            'image',
            'nationFlag',
            'manufactureIdHasProductId',
            'manufactureIdHasProductId.productId',
            'manufactureIdHasProductId.productId.thumbnail',
            'manufactureIdHasProductId.productId.product' => function($query){
                $query->where('language_code', getLocale());
            },
        ])
        ->where('id', $id)
        ->orderBy('sort')
        ->first()
        ->toArray();

        return view('frontend.pages.about.popup.manufacture', compact('manufacture'))->render();
    }
}
