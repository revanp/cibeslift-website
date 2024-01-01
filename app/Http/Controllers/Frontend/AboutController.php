<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryId;
use App\Models\NationId;
use App\Models\ManufactureId;
use App\Models\AboutUsHighlightImage;
use App\Models\AboutUsHighlightId;

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

        return view('frontend.pages.about.index', compact('history', 'nation', 'manufacture', 'highlightImage', 'highlight'));
    }
}
