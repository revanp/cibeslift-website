<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategoryId;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index($lang)
    {
        $products = Product::with([
            'productId',
            // 'productId.productChild'
        ])
        ->where('language_code', $lang)
        ->whereHas('productId', function($query){
            $query->where('level', 1);
        })
        ->get();

        return view('frontend.pages.product.index', compact('products'));
    }

    public function product($lang, $categorySlug)
    {
        $category = ProductCategory::with([
            'productCategoryId',
            'productCategoryId.banner',
            'productCategoryId.productCategoryUspId',
            'productCategoryId.productCategoryUspId.productCategoryUsp' => function($query){
                $query->where('language_code', getLocale());
            },
            'productCategoryId.productCategoryUspId.image',
            'productCategoryId.productId',
            'productCategoryId.productId.product' => function($query){
                $query->where('language_code', getLocale());
            },
            'productCategoryId.productId.spesificationImage',
        ])
        ->where('slug', $categorySlug)
        ->where('language_code', getLocale())
        ->first();

        if(empty($category)){
            abort(404);
        }

        return view('frontend.pages.product.product', compact('category'));
    }

    public function detail($lang, $categorySlug, $productSlug)
    {
        return view('frontend.pages.product.detail');
    }
}
