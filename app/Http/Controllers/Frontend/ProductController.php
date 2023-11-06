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

    public function product($lang, $slug)
    {
        $product = Product::with([
            'productId',
            'productId.productUspId',
            'productId.productUspId.image',
            'productId.productUspId.productUsp' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.productIdHasProductTechnologyId',
            'productId.productIdHasProductTechnologyId.productTechnologyId',
            'productId.productIdHasProductTechnologyId.productTechnologyId.image',
            'productId.productIdHasProductTechnologyId.productTechnologyId.productTechnology' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.productFeatureId',
            'productId.productFeatureId.image',
            'productId.productFeatureId.productFeature' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.productFaqId',
            'productId.productFaqId.productFaq' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.banner',
            'productId.child'
        ])
        ->where('slug', $slug)
        ->where('language_code', getLocale())
        ->whereHas('productId', function($query){
            $query->where('level', 1);
        })
        ->first();

        if(empty($product)){
            abort(404);
        }

        $product = $product->toArray();

        return view('frontend.pages.product.product', compact('product'));
    }

    public function detail($lang, $categorySlug, $productSlug)
    {
        return view('frontend.pages.product.detail');
    }
}
