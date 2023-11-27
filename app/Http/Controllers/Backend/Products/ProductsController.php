<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

# MODELS
use App\Models\Faq;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductUsp;
use App\Models\ProductUspId;
use App\Models\ProductSpecification;
use App\Models\ProductTechnology;
use App\Models\ProductIdHasProductTechnologyId;
use App\Models\ProductIdHasFaqId;
use App\Models\ProductFeature;
use App\Models\ProductFeatureId;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = Product::with([
                'productId',
                'productId.parent',
                'productId.parent.product' => function($query){
                    $query->where('language_code', 'id');
                },
            ])
            ->where('language_code', 'id');

            if ($reqDatatable['orderable']) {
                foreach ($reqDatatable['orderable'] as $order) {
                    if($order['column'] == 'rownum') {
                        $data = $data->orderBy('id', $order['dir']);
                    } else {
                        if(!empty($val['column'])){
                            $data = $data->orderBy($order['column'], $order['dir']);
                        }else{
                            $data = $data->orderBy('id', 'desc');
                        }
                    }
                }
            } else {
                $data = $data->orderBy('id', 'asc');
            }

            $datatables = DataTables::of($data);

            if (isset($reqDatatable['orderable']['rownum'])) {
                if ($reqDatatable['orderable']['rownum']['dir'] == 'desc') {
                    $rownum      = abs($data->count() - ($reqDatatable['start'] * $reqDatatable['length']));
                    $is_increase = false;
                } else {
                    $rownum = ($reqDatatable['start'] * $reqDatatable['length']) + 1;
                    $is_increase = true;
                }
            } else {
                $rownum      = ($reqDatatable['start'] * $reqDatatable['length']) + 1;
                $is_increase = true;
            }

            return $datatables
                ->addColumn('rownum', function() use (&$rownum, $is_increase) {
                    if ($is_increase == true) {
                        return $rownum++;
                    } else {
                        return $rownum--;
                    }
                })
                ->addColumn('level', function($data){
                    return '<span class="label label-rounded">'.$data->productId->level.'</span>';
                })
                ->addColumn('parent', function($data){
                    if(!empty($data->productId->parent)){
                        return $data->productId->parent->product[0]->name;
                    }else{
                        return '';
                    }
                })
                ->addColumn('is_active', function($data){
                    $id = $data->productId->id;
                    $isActive = $data->productId->is_active;

                    return view('backend.pages.products.products.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* CUSTOMIZATION
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/products/customizations/'.$data->productId->id) .'"><i class="flaticon2-cube-1 nav-icon"></i><span class="nav-text">Customization</span></a></li>';

                        //* VIEW
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/products/view/'.$data->productId->id) .'"><i class="flaticon-eye nav-icon"></i><span class="nav-text">View</span></a></li>';

                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/products/edit/'.$data->productId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/products/products/delete/'.$data->productId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['level', 'image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.products.products.index');
    }

    public function view($id)
    {
        $data = ProductId::with([
            'product',
            'productSpecification',
            'banner',
            'specificationImage',
            'thumbnail',
            'menuIcon',
            'productSummaryImage',
            'productUspId',
            'productUspId.image',
            'productUspId.productUsp',
            'productFeatureId',
            'productFeatureId.image',
            'productFeatureId.productFeature',
            'productIdHasProductTechnologyId',
            'productIdHasProductTechnologyId.productTechnologyId',
            'productIdHasProductTechnologyId.productTechnologyId.productTechnology' => function($query){
                $query->where('language_code', 'id');
            },
            'productIdHasFaqId',
            'productIdHasFaqId.faqId',
            'productIdHasFaqId.faqId.faq' => function($query){
                $query->where('language_code', 'id');
            },
            'productCustomizationId',
            'productCustomizationId.productCustomization' => function($query){
                $query->where('language_code', 'id');
            },
            'productCustomizationId.productCustomizationFeatureId',
            'productCustomizationId.productCustomizationFeatureId.productCustomizationFeature' => function($query){
                $query->where('language_code', 'id');
            },
            'productCustomizationId.productCustomizationOptionId',
            'productCustomizationId.productCustomizationOptionId.productCustomizationOption' => function($query){
                $query->where('language_code', 'id');
            },
            'productCustomizationId.productCustomizationOptionId.productCustomizationOptionVariationId',
            'productCustomizationId.productCustomizationOptionId.productCustomizationOptionVariationId.productCustomizationOptionVariation' => function($query){
                $query->where('language_code', 'id');
            },
            'productCustomizationId.productCustomizationOptionId.productCustomizationOptionVariationId.image'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['product'] as $key => $val) {
            $data['product'][$val['language_code']] = $val;
            unset($data['product'][$key]);
        }

        foreach ($data['product_usp_id'] as $key => $val) {
            foreach ($val['product_usp'] as $key2 => $val2) {
                $data['product_usp_id'][$key]['product_usp'][$val2['language_code']] = $val2;
                unset($data['product_usp_id'][$key]['product_usp'][$key2]);
            }
        }

        foreach ($data['product_feature_id'] as $key => $val) {
            foreach ($val['product_feature'] as $key2 => $val2) {
                $data['product_feature_id'][$key]['product_feature'][$val2['language_code']] = $val2;
                unset($data['product_feature_id'][$key]['product_feature'][$key2]);
            }
        }

        return view('backend.pages.products.products.view', compact('data'));
    }

    public function create()
    {
        $technologies = ProductTechnology::with('productTechnologyId')->where('language_code', '=', 'id')->whereHas('productTechnologyId', function($query){
            $query->where('is_active', 1);
        })->get();

        $faqs = Faq::with('faqId')
            ->where('language_code', '=', 'id')->whereHas('faqId', function($query){
                $query->where('is_active', 1);
            })
            ->get();

        $parents = Product::with(['productId'])
            ->where('language_code', 'en')
            ->whereHas('productId', function($query){
                $query->where('level', 1);
                $query->where('have_a_child', true);
            })
            ->get();

        $sort = ProductId::count() + 1;

        return view('backend.pages.products.products.create', compact('sort', 'technologies', 'parents', 'faqs'));
    }

    public function validation(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        if($data['form_type'] == 'create'){
            $rules = [
                'banner' => ['required', 'file'],
                'thumbnail' => ['file'],
                'specification_image' => ['file'],
                // 'product_summary_type' => ['required'],
                'sort' => [],
                'technologies' => ['required', 'array']
            ];

            $messages = [];

            $attributes = [
                'banner' => 'Banner',
                'thumbnail' => 'Thumbnail',
                'spesification_image' => 'Spesification Image',
                'product_summary_type' => 'Product Summary Type',
                'sort' => 'Sort',
                'technologies' => 'Technologies'
            ];

            foreach ($request->input as $lang => $input) {
                if($lang == 'id'){
                    $rules["input.$lang.name"] = ['required'];
                    $rules["input.$lang.short_description"] = ['required'];
                    $rules["input.$lang.description"] = [];
                    $rules["input.$lang.page_title"] = ['required'];
                }else{
                    $rules["input.$lang.name"] = [];
                    $rules["input.$lang.short_description"] = [];
                    $rules["input.$lang.description"] = [];
                    $rules["input.$lang.page_title"] = [];
                }

                $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                $attributes["input.$lang.name"] = "$lang_name Name";
                $attributes["input.$lang.short_description"] = "$lang_name Short Description";
                $attributes["input.$lang.description"] = "$lang_name Description";
                $attributes["input.$lang.page_title"] = "$lang_name Page Title";
            }

            if(empty($data['have_a_child'])){
                $rules['specification.size'] = ['required'];
                $rules['specification.installation'] = ['required'];
                $rules['specification.rated_load'] = [''];
                $rules['specification.power_supply'] = ['required'];
                $rules['specification.speed'] = ['required'];
                $rules['specification.min_headroom'] = ['required'];
                $rules['specification.lift_pit'] = ['required'];
                $rules['specification.drive_system'] = ['required'];
                $rules['specification.max_travel'] = ['required'];
                $rules['specification.max_number_of_stops'] = ['required'];
                $rules['specification.lift_controls'] = [''];
                $rules['specification.motor_power'] = [''];
                $rules['specification.machine_room'] = [''];
                $rules['specification.door_configuration'] = ['required'];
                $rules['specification.directive_and_standards'] = [''];

                $attributes['specification.size'] = 'Size';
                $attributes['specification.installation'] = 'Installation';
                $attributes['specification.rated_load'] = 'Rated Load';
                $attributes['specification.power_supply'] = 'Power Supply';
                $attributes['specification.speed'] = 'Speed';
                $attributes['specification.min_headroom'] = 'Min. Headroom';
                $attributes['specification.lift_pit'] = 'Lift Pit';
                $attributes['specification.drive_system'] = 'Drive System';
                $attributes['specification.max_travel'] = 'Max Travel';
                $attributes['specification.max_number_of_stops'] = 'Max. Number Of Stops';
                $attributes['specification.lift_controls'] = 'Lift Controls';
                $attributes['specification.motor_power'] = 'Motor Power';
                $attributes['specification.machine_room'] = 'Machine Room';
                $attributes['specification.door_configuration'] = 'Doors configuration';
                $attributes['specification.directive_and_standards'] = 'Directive and Standards';
            }

            foreach ($request->usp as $key => $input) {
                $rules['usp.'.$key.'.image'] = ['required'];

                $attributes['usp.'.$key.'.image'] = 'USP Image ' . $key + 1;

                foreach($input['input'] as $lang => $input2){
                    if($lang == 'id'){
                        $rules["usp.". $key . ".input.". $lang.".name"] = ['required'];
                        $rules["usp.". $key . ".input.". $lang.".description"] = [];
                    }else{
                        $rules["usp.". $key . ".input.". $lang.".name"] = [];
                        $rules["usp.". $key . ".input.". $lang.".description"] = [];
                    }

                    $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                    $attributes["usp.". $key . ".input.". $lang.".name"] = "USP $lang_name Name " . $key + 1;
                    $attributes["usp.". $key . ".input.". $lang.".description"] = "USP $lang_name Description " . $key + 1;
                }
            }

            foreach ($request->feature as $key => $input) {
                $rules['feature.'.$key.'.image'] = ['required'];

                $attributes['feature.'.$key.'.image'] = 'Feature Image ' . $key + 1;

                foreach($input['input'] as $lang => $input2){
                    if($lang == 'id'){
                        $rules["feature.". $key . ".input.". $lang.".name"] = ['required'];
                        $rules["feature.". $key . ".input.". $lang.".description"] = [];
                    }else{
                        $rules["feature.". $key . ".input.". $lang.".name"] = [];
                        $rules["feature.". $key . ".input.". $lang.".description"] = [];
                    }

                    $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                    $attributes["feature.". $key . ".input.". $lang.".name"] = "Feature $lang_name Name " . $key + 1;
                    $attributes["feature.". $key . ".input.". $lang.".description"] = "Feature $lang_name Description " . $key + 1;
                }
            }
        }else{
            $rules = [
                'banner' => ['file'],
                'thumbnail' => ['file'],
                'specification_image' => ['file'],
                // 'product_summary_type' => ['required'],
                'sort' => [],
                'technologies' => ['required', 'array']
            ];

            $messages = [];

            $attributes = [
                'banner' => 'Banner',
                'thumbnail' => 'Thumbnail',
                'spesification_image' => 'Spesification Image',
                'product_summary_type' => 'Product Summary Type',
                'sort' => 'Sort',
                'technologies' => 'Technologies'
            ];

            foreach ($request->input as $lang => $input) {
                if($lang == 'id'){
                    $rules["input.$lang.name"] = ['required'];
                    $rules["input.$lang.short_description"] = ['required'];
                    $rules["input.$lang.description"] = [];
                    $rules["input.$lang.page_title"] = ['required'];
                }else{
                    $rules["input.$lang.name"] = [];
                    $rules["input.$lang.short_description"] = [];
                    $rules["input.$lang.description"] = [];
                    $rules["input.$lang.page_title"] = [];
                }

                $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                $attributes["input.$lang.name"] = "$lang_name Name";
                $attributes["input.$lang.short_description"] = "$lang_name Short Description";
                $attributes["input.$lang.description"] = "$lang_name Description";
                $attributes["input.$lang.page_title"] = "$lang_name Page Title";
            }

            if(empty($data['have_a_child'])){
                $rules['specification.size'] = ['required'];
                $rules['specification.installation'] = ['required'];
                $rules['specification.rated_load'] = [''];
                $rules['specification.power_supply'] = ['required'];
                $rules['specification.speed'] = ['required'];
                $rules['specification.min_headroom'] = ['required'];
                $rules['specification.lift_pit'] = ['required'];
                $rules['specification.drive_system'] = ['required'];
                $rules['specification.max_travel'] = ['required'];
                $rules['specification.max_number_of_stops'] = ['required'];
                $rules['specification.lift_controls'] = [''];
                $rules['specification.motor_power'] = [''];
                $rules['specification.machine_room'] = [''];
                $rules['specification.door_configuration'] = ['required'];
                $rules['specification.directive_and_standards'] = [''];

                $attributes['specification.size'] = 'Size';
                $attributes['specification.installation'] = 'Installation';
                $attributes['specification.rated_load'] = 'Rated Load';
                $attributes['specification.power_supply'] = 'Power Supply';
                $attributes['specification.speed'] = 'Speed';
                $attributes['specification.min_headroom'] = 'Min. Headroom';
                $attributes['specification.lift_pit'] = 'Lift Pit';
                $attributes['specification.drive_system'] = 'Drive System';
                $attributes['specification.max_travel'] = 'Max Travel';
                $attributes['specification.max_number_of_stops'] = 'Max. Number Of Stops';
                $attributes['specification.lift_controls'] = 'Lift Controls';
                $attributes['specification.motor_power'] = 'Motor Power';
                $attributes['specification.machine_room'] = 'Machine Room';
                $attributes['specification.door_configuration'] = 'Doors configuration';
                $attributes['specification.directive_and_standards'] = 'Directive and Standards';
            }

            foreach ($request->usp as $key => $input) {
                $rules['usp.'.$key.'.image'] = [''];

                $attributes['usp.'.$key.'.image'] = 'USP Image ' . $key + 1;

                foreach($input['input'] as $lang => $input2){
                    if($lang == 'id'){
                        $rules["usp.". $key . ".input.". $lang.".name"] = ['required'];
                        $rules["usp.". $key . ".input.". $lang.".description"] = [];
                    }else{
                        $rules["usp.". $key . ".input.". $lang.".name"] = [];
                        $rules["usp.". $key . ".input.". $lang.".description"] = [];
                    }

                    $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                    $attributes["usp.". $key . ".input.". $lang.".name"] = "USP $lang_name Name " . $key + 1;
                    $attributes["usp.". $key . ".input.". $lang.".description"] = "USP $lang_name Description " . $key + 1;
                }
            }

            foreach ($request->feature as $key => $input) {
                $rules['feature.'.$key.'.image'] = [''];

                $attributes['feature.'.$key.'.image'] = 'Feature Image ' . $key + 1;

                foreach($input['input'] as $lang => $input2){
                    if($lang == 'id'){
                        $rules["feature.". $key . ".input.". $lang.".name"] = ['required'];
                        $rules["feature.". $key . ".input.". $lang.".description"] = [];
                    }else{
                        $rules["feature.". $key . ".input.". $lang.".name"] = [];
                        $rules["feature.". $key . ".input.". $lang.".description"] = [];
                    }

                    $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                    $attributes["feature.". $key . ".input.". $lang.".name"] = "Feature $lang_name Name " . $key + 1;
                    $attributes["feature.". $key . ".input.". $lang.".description"] = "Feature $lang_name Description " . $key + 1;
                }
            }
        }

        $validator = Validator::make($data, $rules, $messages, $attributes);

        if($validator->fails()){
            return response()->json([
                'code' => 422,
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors()
            ], 422)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ]);
        }else{
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Validation success!',
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $isError = false;

        try {
            DB::beginTransaction();

            $productId = new ProductId();

            $sort = empty($data['sort']) ? ProductId::count() + 1 : $data['sort'];

            $productId->fill([
                'sort' => $sort,
                'product_summary_type' => $data['product_summary_type'],
                'level' => !empty($data['parent_id']) ? 2 : 1,
                'parent_id' => $data['parent_id'] ?? null,
                'video_url' => $data['video_url'] ?? null,
                'have_a_child' => !empty($data['have_a_child']) ? true : false,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idProductId = $productId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $product = new Product();

                $input['id_product_id'] = $idProductId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['short_description'] = $data['input']['en']['short_description'] ?? $data['input']['id']['short_description'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                    $input['video_description'] = $data['input']['en']['video_description'] ?? $data['input']['id']['video_description'];
                    $input['page_title'] = $data['input']['en']['page_title'] ?? $data['input']['id']['page_title'];
                    $input['seo_title'] = $data['input']['en']['seo_title'] ?? $data['input']['id']['seo_title'];
                    $input['seo_description'] = $data['input']['en']['seo_description'] ?? $data['input']['id']['seo_description'];
                    $input['seo_keyword'] = $data['input']['en']['seo_keyword'] ?? $data['input']['id']['seo_keyword'];
                    $input['seo_canonical_url'] = $data['input']['en']['seo_canonical_url'] ?? $data['input']['id']['seo_canonical_url'];
                }

                $input['slug'] = Str::slug($input['name']);

                $product->fill($input)->save();

                $idProduct = $product->id;
            }

            foreach($data['technologies'] as $key => $val){
                $productIdHasProductTechnologyId = new ProductIdHasProductTechnologyId();
                $productIdHasProductTechnologyId->fill([
                    'id_product_technology_id' => $val,
                    'id_product_id' => $idProductId,
                ])->save();
            }

            foreach($data['faqs'] as $key => $val){
                $productIdHasFaqId = new ProductIdHasFaqId();
                $productIdHasFaqId->fill([
                    'id_faq_id' => $val,
                    'id_product_id' => $idProductId,
                ])->save();
            }

            $specification = new ProductSpecification();
            $data['specification']['id_product_id'] = $idProductId;

            $specification->fill($data['specification'])->save();

            foreach($data['usp'] as $key => $val){
                $uspId = new ProductUspId();

                $uspId->fill([
                    'id_product_id' => $idProductId
                ])->save();

                $idUspId = $uspId->id;

                if ($request->hasFile('usp.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('usp.'.$key.'.image'),
                        $uspId,
                        'image',
                        "images/products/products/usp/{$idUspId}",
                        'image'
                    );
                }

                foreach($val['input'] as $languageCode2 => $val2){
                    $usp = new ProductUsp();

                    $dataUsp['id_product_usp_id'] = $idUspId;
                    $dataUsp['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataUsp['name'] = $data['usp'][$key]['input']['en']['name'] ?? $data['usp'][$key]['input']['id']['name'];
                        $dataUsp['description'] = $data['usp'][$key]['input']['en']['description'] ?? $data['usp'][$key]['input']['id']['description'];
                    }else{
                        $dataUsp['name'] = $val2['name'];
                        $dataUsp['description'] = $val2['description'];
                    }

                    $usp->fill($dataUsp)->save();
                }
            }

            foreach($data['feature'] as $key => $val){
                $featureId = new ProductFeatureId();

                $featureId->fill([
                    'id_product_id' => $idProductId
                ])->save();

                $idFeatureId = $featureId->id;

                if ($request->hasFile('feature.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('feature.'.$key.'.image'),
                        $featureId,
                        'image',
                        "images/products/products/feature/{$idFeatureId}",
                        'image'
                    );
                }

                foreach($val['input'] as $languageCode2 => $val2){
                    $feature = new ProductFeature();

                    $dataFeature['id_product_feature_id'] = $idFeatureId;
                    $dataFeature['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataFeature['name'] = $data['feature'][$key]['input']['en']['name'] ?? $data['feature'][$key]['input']['id']['name'];
                        $dataFeature['description'] = $data['feature'][$key]['input']['en']['description'] ?? $data['feature'][$key]['input']['id']['description'];
                    }else{
                        $dataFeature['name'] = $val2['name'];
                        $dataFeature['description'] = $val2['description'];
                    }

                    $feature->fill($dataFeature)->save();
                }
            }

            if ($request->hasFile('banner')) {
                $this->storeFile(
                    $request->file('banner'),
                    $productId,
                    'banner',
                    "images/products/products/banner/{$idProductId}",
                    'banner'
                );
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $productId,
                    'thumbnail',
                    "images/products/products/thumbnail/{$idProductId}",
                    'thumbnail'
                );
            }

            if ($request->hasFile('specification_image')) {
                $this->storeFile(
                    $request->file('specification_image'),
                    $productId,
                    'specificationImage',
                    "images/products/products/spesification-image/{$idProductId}",
                    'specification_image'
                );
            }

            if ($request->hasFile('menu_icon')) {
                $this->storeFile(
                    $request->file('menu_icon'),
                    $productId,
                    'menuIcon',
                    "images/products/products/menu-icon/{$idProductId}",
                    'menu_icon'
                );
            }

            if ($request->hasFile('product_summary_image')) {
                $this->storeFile(
                    $request->file('product_summary_image'),
                    $productId,
                    'productSummaryImage',
                    "images/products/products/product-summary-image/{$idProductId}",
                    'product_summary_image'
                );
            }

            $message = 'Product created successfully';

            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            $isError = true;

            $err     = $e->errorInfo;

            $message =  $err[2];
        }

        if ($isError == true) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => $message
            ], 500)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ]);
        }else{
            session()->flash('success', $message);

            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => $message,
                'redirect' => url('admin-cms/products/products')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = ProductId::with([
            'product',
            'productSpecification',
            'banner',
            'specificationImage',
            'thumbnail',
            'menuIcon',
            'productSummaryImage',
            'productUspId',
            'productUspId.image',
            'productUspId.productUsp',
            'productFeatureId',
            'productFeatureId.image',
            'productFeatureId.productFeature',
            'productIdHasProductTechnologyId',
            'productIdHasFaqId'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['product'] as $key => $val) {
            $data['product'][$val['language_code']] = $val;
            unset($data['product'][$key]);
        }

        foreach ($data['product_usp_id'] as $key => $val) {
            foreach ($val['product_usp'] as $key2 => $val2) {
                $data['product_usp_id'][$key]['product_usp'][$val2['language_code']] = $val2;
                unset($data['product_usp_id'][$key]['product_usp'][$key2]);
            }
        }

        foreach ($data['product_feature_id'] as $key => $val) {
            foreach ($val['product_feature'] as $key2 => $val2) {
                $data['product_feature_id'][$key]['product_feature'][$val2['language_code']] = $val2;
                unset($data['product_feature_id'][$key]['product_feature'][$key2]);
            }
        }

        $productIdHasProductTechnologyId = $data['product_id_has_product_technology_id'];
        unset($data['product_id_has_product_technology_id']);
        foreach($productIdHasProductTechnologyId as $key => $val){
            $data['product_id_has_product_technology_id'][$key] = $val['id_product_technology_id'];
        }

        $productIdHasProductTechnologyId = $data['product_id_has_faq_id'];
        unset($data['product_id_has_faq_id']);
        foreach($productIdHasProductTechnologyId as $key => $val){
            $data['product_id_has_faq_id'][$key] = $val['id_faq_id'];
        }

        $technologies = ProductTechnology::with('productTechnologyId')->where('language_code', '=', 'id')->whereHas('productTechnologyId', function($query){
            $query->where('is_active', 1);
        })->get();

        $faqs = Faq::with('faqId')
        ->where('language_code', '=', 'id')->whereHas('faqId', function($query){
            $query->where('is_active', 1);
        })
        ->get();

        $parents = Product::with(['productId'])
            ->where('language_code', 'en')
            ->whereHas('productId', function($query){
                $query->where('level', 1);
                $query->where('have_a_child', true);
            })
            ->get();

        $sort = ProductId::count() + 1;

        return view('backend.pages.products.products.edit', compact('data', 'sort', 'parents', 'technologies', 'faqs'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $isError = false;

        try {
            DB::beginTransaction();

            $productId = ProductId::find($id);

            $sort = empty($data['sort']) ? ProductId::count() + 1 : $data['sort'];

            $productId->fill([
                'sort' => $sort,
                'product_summary_type' => $data['product_summary_type'],
                'level' => !empty($data['parent_id']) ? 2 : 1,
                'parent_id' => $data['parent_id'] ?? null,
                'video_url' => $data['video_url'] ?? null,
                'have_a_child' => !empty($data['have_a_child']) ? true : false,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idProductId = $productId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $product = Product::where('id_product_id', $id)->where('language_code', $languageCode)->first();

                $input['id_product_id'] = $idProductId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['short_description'] = $data['input']['en']['short_description'] ?? $data['input']['id']['short_description'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                    $input['video_description'] = $data['input']['en']['video_description'] ?? $data['input']['id']['video_description'];
                    $input['page_title'] = $data['input']['en']['page_title'] ?? $data['input']['id']['page_title'];
                    $input['seo_title'] = $data['input']['en']['seo_title'] ?? $data['input']['id']['seo_title'];
                    $input['seo_description'] = $data['input']['en']['seo_description'] ?? $data['input']['id']['seo_description'];
                    $input['seo_keyword'] = $data['input']['en']['seo_keyword'] ?? $data['input']['id']['seo_keyword'];
                    $input['seo_canonical_url'] = $data['input']['en']['seo_canonical_url'] ?? $data['input']['id']['seo_canonical_url'];
                }

                $input['slug'] = Str::slug($input['name']);

                $product->fill($input)->save();

                $idProduct = $product->id;
            }

            ProductIdHasProductTechnologyId::where('id_product_id', $idProductId)->delete();
            foreach($data['technologies'] as $key => $val){
                $productIdHasProductTechnologyId = new ProductIdHasProductTechnologyId();
                $productIdHasProductTechnologyId->fill([
                    'id_product_technology_id' => $val,
                    'id_product_id' => $idProductId,
                ])->save();
            }

            ProductIdHasFaqId::where('id_product_id', $idProductId)->delete();
            foreach($data['faqs'] as $key => $val){
                $productIdHasFaqId = new ProductIdHasFaqId();
                $productIdHasFaqId->fill([
                    'id_faq_id' => $val,
                    'id_product_id' => $idProductId,
                ])->save();
            }

            $specification = ProductSpecification::where('id_product_id', $id)->first();
            $data['specification']['id_product_id'] = $idProductId;

            $specification->fill($data['specification'])->save();

            foreach($data['usp'] as $key => $val){
                if(!empty($val['id'])){
                    $uspId = ProductUspId::find($val['id']);
                }else{
                    $uspId = new ProductUspId();
                }

                $uspId->fill([
                    'id_product_id' => $idProductId
                ])->save();

                $idUspId = $uspId->id;

                if ($request->hasFile('usp.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('usp.'.$key.'.image'),
                        $uspId,
                        'image',
                        "images/products/products/usp/{$idUspId}",
                        'image'
                    );
                }

                foreach($val['input'] as $languageCode2 => $val2){
                    if(!empty($val['id'])){
                        $usp = ProductUsp::where('language_code', $languageCode2)->where('id_product_usp_id', $val['id'])->first();
                    }else{
                        $usp = new ProductUsp();
                    }

                    $dataUsp['id_product_usp_id'] = $idUspId;
                    $dataUsp['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataUsp['name'] = $data['usp'][$key]['input']['en']['name'] ?? $data['usp'][$key]['input']['id']['name'];
                        $dataUsp['description'] = $data['usp'][$key]['input']['en']['description'] ?? $data['usp'][$key]['input']['id']['description'];
                    }else{
                        $dataUsp['name'] = $val2['name'];
                        $dataUsp['description'] = $val2['description'];
                    }

                    $usp->fill($dataUsp)->save();
                }
            }

            foreach($data['feature'] as $key => $val){
                if(!empty($val['id'])){
                    $featureId = ProductFeatureId::find($val['id']);
                }else{
                    $featureId = new ProductFeatureId();
                }

                $featureId->fill([
                    'id_product_id' => $idProductId
                ])->save();

                $idFeatureId = $featureId->id;

                if ($request->hasFile('feature.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('feature.'.$key.'.image'),
                        $featureId,
                        'image',
                        "images/products/products/feature/{$idFeatureId}",
                        'image'
                    );
                }

                foreach($val['input'] as $languageCode2 => $val2){
                    if(!empty($val['id'])){
                        $feature = ProductFeature::where('language_code', $languageCode2)->where('id_product_feature_id', $val['id'])->first();
                    }else{
                        $feature = new ProductFeature();
                    }

                    $dataFeature['id_product_feature_id'] = $idFeatureId;
                    $dataFeature['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataFeature['name'] = $data['feature'][$key]['input']['en']['name'] ?? $data['feature'][$key]['input']['id']['name'];
                        $dataFeature['description'] = $data['feature'][$key]['input']['en']['description'] ?? $data['feature'][$key]['input']['id']['description'];
                    }else{
                        $dataFeature['name'] = $val2['name'];
                        $dataFeature['description'] = $val2['description'];
                    }

                    $feature->fill($dataFeature)->save();
                }
            }

            if ($request->hasFile('banner')) {
                $this->storeFile(
                    $request->file('banner'),
                    $productId,
                    'banner',
                    "images/products/products/banner/{$idProductId}",
                    'banner'
                );
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $productId,
                    'thumbnail',
                    "images/products/products/thumbnail/{$idProductId}",
                    'thumbnail'
                );
            }

            if ($request->hasFile('spesification_image')) {
                $this->storeFile(
                    $request->file('spesification_image'),
                    $productId,
                    'spesificationImage',
                    "images/products/products/spesification-image/{$idProductId}",
                    'spesification_image'
                );
            }

            if ($request->hasFile('menu_icon')) {
                $this->storeFile(
                    $request->file('menu_icon'),
                    $productId,
                    'menuIcon',
                    "images/products/products/menu-icon/{$idProductId}",
                    'menu_icon'
                );
            }

            if ($request->hasFile('product_summary_image')) {
                $this->storeFile(
                    $request->file('product_summary_image'),
                    $productId,
                    'productSummaryImage',
                    "images/products/products/product-summary-image/{$idProductId}",
                    'product_summary_image'
                );
            }

            $message = 'Product updated successfully';

            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            $isError = true;

            $err     = $e->errorInfo;

            $message =  $err[2];
        }

        if ($isError == true) {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => $message
            ], 500)
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ]);
        }else{
            session()->flash('success', $message);

            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => $message,
                'redirect' => url('admin-cms/products/products')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function changeStatus(Request $request)
    {
        $input = $request->all();
        $isAjax = $request->ajax() ? true : false;
        $user   = Auth::user();

        unset($input['_token']);

        if($isAjax){
            $id = $input['id'];
            $isError = true;

            $status = $input['status'] == '0' ? false : true;

            try {
                DB::beginTransaction();

                $update = ProductId::where('id', $id)->update([
                    'is_active' => $status
                ]);

                DB::commit();

                return response([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Status has been changed successfully'
                ]);
            }catch(Exception $e){
                DB::rollBack();

                return response([
                    'success' => false,
                    'code' => 500,
                    'message' => 'Something went wrong'
                ]);
            }
        }
    }

    public function delete($id)
    {
        try{
            DB::beginTransaction();

            $delete = ProductId::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            $deleteChild = Product::where('id_product_od', $id)->delete();

            DB::commit();

            return redirect('admin-cms/products/products')->with(['success' => 'Product has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
