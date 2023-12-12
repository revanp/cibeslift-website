<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HeaderBanner;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $headerBanner = HeaderBanner::with([
            'headerBannerId',
            'headerBannerId.image',
        ])
        ->where('language_code', getLocale())
        ->first();

        return view('home', compact('headerBanner'));
    }
}
