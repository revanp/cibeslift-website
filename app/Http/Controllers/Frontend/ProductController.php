<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategoryId;
use App\Models\ProductCategory;
use App\Models\ProductEuropeanStandard;
use App\Models\ProductTechnology;
use App\Models\ProductTechnologyMoreFeatureImage;
use App\Models\ProductCustomizationId;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    public function index($lang)
    {
        $products = Product::with([
            'productId',
            'productId.productSummaryImage',
            'productId.child',
            'productId.child.product' => function($query) use($lang){
                $query->where('language_code', $lang);
            },
            'productId.child.thumbnail',
        ])
        ->where('language_code', $lang)
        ->whereHas('productId', function($query){
            $query->where('is_active', 1);
            $query->where('level', 1);
        })
        ->get();

        if(!empty($products)){
            $products = $products->toArray();
        }

        $productTechnologies = ProductTechnology::with([
            'productTechnologyId',
            'productTechnologyId.image'
        ])
        ->where('language_code', $lang)
        ->whereHas('productTechnologyId', function($query){
            $query->where('is_active', 1);
        });

        $countTechnologies = $productTechnologies->count();
        if($productTechnologies->count() <= 6){
            $productTechnologies = $productTechnologies->limit(6);
        }else{
            $productTechnologies = $productTechnologies->limit(5);
        }
        $productTechnologies = $productTechnologies->get();

        if(!empty($productTechnologies)){
            $productTechnologies = $productTechnologies->toArray();
        }

        $technologyImage = ProductTechnologyMoreFeatureImage::with('image')->first();

        $productEuropeanStandard = ProductEuropeanStandard::with([
            'productEuropeanStandardId',
            'productEuropeanStandardId.image'
        ])
        ->where('language_code', $lang)
        ->whereHas('productEuropeanStandardId', function($query){
            $query->where('is_active', 1);
        })
        ->get();

        if(!empty($productEuropeanStandard)){
            $productEuropeanStandard = $productEuropeanStandard->toArray();
        }

        return view('frontend.pages.product.index', compact('products', 'productTechnologies', 'countTechnologies', 'technologyImage', 'productEuropeanStandard'));
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
            'productId.productHighlightId',
            'productId.productHighlightId.image',
            'productId.productHighlightId.productHighlight' => function($query){
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
            'productId.productIdHasFaqId',
            'productId.productIdHasFaqId.faqId',
            'productId.productIdHasFaqId.faqId.faq' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.banner',
            'productId.contactUsImage',
            'productId.specificationImage',
            'productId.productSpecification',
            'productId.child',
            'productId.child.thumbnail',
            'productId.child.specificationImage',
            'productId.child.product' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.productCustomizationId',
            'productId.productCustomizationId.image',
            'productId.productCustomizationId.productCustomization' => function($query){
                $query->where('language_code', getLocale());
            },
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

        if($product['product_id']['have_a_child']){
            return view('frontend.pages.product.product', compact('product'));
        }else{
            return view('frontend.pages.product.detail', compact('product'));
        }

    }

    public function detail($lang, $slug, $productSlug)
    {
        $productLevel1 = Product::where('slug', $slug)
            ->where('language_code', getLocale())
            ->whereHas('productId', function($query){
                $query->where('level', 1);
            })
            ->first();

        if(empty($productLevel1)){
            abort(404);
        }

        $product = Product::with([
            'productId',
            'productId.productUspId',
            'productId.productUspId.image',
            'productId.productUspId.productUsp' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.productHighlightId',
            'productId.productHighlightId.image',
            'productId.productHighlightId.productHighlight' => function($query){
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
            'productId.productIdHasFaqId',
            'productId.productIdHasFaqId.faqId',
            'productId.productIdHasFaqId.faqId.faq' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.banner',
            'productId.contactUsImage',
            'productId.specificationImage',
            'productId.productSpecification',
            'productId.child',
            'productId.child.thumbnail',
            'productId.child.specificationImage',
            'productId.child.product' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.productCustomizationId',
            'productId.productCustomizationId.image',
            'productId.productCustomizationId.productCustomization' => function($query){
                $query->where('language_code', getLocale());
            },
        ])
        ->where('slug', $productSlug)
        ->where('language_code', getLocale())
        ->whereHas('productId', function($query){
            $query->where('level', 2);
        })
        ->first();

        if(empty($product)){
            abort(404);
        }

        $product = $product->toArray();

        return view('frontend.pages.product.detail', compact('product'));
    }

    public function getCustomization(Request $request)
    {
        $id = Crypt::decrypt($request->id);

        $customization = ProductCustomizationId::with([
            'productCustomization' => function($query){
                $query->where('language_code', getLocale());
            },
            'image',
            'productCustomizationFeatureId',
            'productCustomizationFeatureId.image',
            'productCustomizationFeatureId.productCustomizationFeature' => function($query){
                $query->where('language_code', getLocale());
            },
            'productCustomizationOptionId',
            'productCustomizationOptionId.productCustomizationOption',
            'productCustomizationOptionId.productCustomizationOptionVariationId',
            'productCustomizationOptionId.productCustomizationOptionVariationId.image',
            'productCustomizationOptionId.productCustomizationOptionVariationId.productCustomizationOptionVariation' => function($query){
                $query->where('language_code', getLocale());
            },
        ])
        ->find($id)
        ->toArray();

        return view('frontend.pages.product.popup.customization', compact('customization'))->render();
    }
}
