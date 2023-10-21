<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategoryId;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index()
    {
        return view('frontend.pages.product.index');
    }

    public function product($lang, $slug)
    {
        $category = ProductCategory::with([
            'productCategoryId',
            'productCategoryId.banner'
        ])
        ->where('slug', $slug)
        ->where('language_code', getLocale())
        ->first();

        if(empty($category)){
            abort(404);
        }

        return view('frontend.pages.product.product', compact('category'));
    }

    public function detail()
    {
        return view('frontend.pages.product.detail');
    }
}
