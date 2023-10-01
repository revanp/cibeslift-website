<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function create()
    {
        return view('backend.pages.products.categories.create');
    }
}
