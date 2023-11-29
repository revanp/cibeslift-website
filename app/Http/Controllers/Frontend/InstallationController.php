<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function index()
    {
        return view('frontend.pages.installation.index');
    }

    public function archive()
    {
        return view('frontend.pages.installation.archive');
    }

    public function detail()
    {
        return view('frontend.pages.installation.detail');
    }
}
