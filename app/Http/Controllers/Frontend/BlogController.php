<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('frontend.pages.blog.index');
    }

    public function detail()
    {
        return view('frontend.pages.blog.detail');
    }
}
