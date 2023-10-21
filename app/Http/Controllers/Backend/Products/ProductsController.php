<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategoryId;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductImage;
use App\Models\ProductImageId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = Product::with([
                'productId',
                'productId.productCategoryId',
                'productId.productCategoryId.productCategory' => function($query){
                    $query->where('language_code', 'id');
                },
            ])->where('language_code', 'id');

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
                $data = $data->orderBy('id', 'desc');
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
                ->addColumn('category', function($data){
                    return $data->productId->productCategoryId->productCategory[0]->name;
                })
                ->addColumn('is_active', function($data){
                    $id = $data->productId->id;
                    $isActive = $data->productId->is_active;

                    return view('backend.pages.products.products.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* CUSTOMIZATION
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/customizations/'.$data->productId->id) .'"><i class="flaticon2-cube-1 nav-icon"></i><span class="nav-text">Customization</span></a></li>';

                        //* FEATURE
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/features/'.$data->productId->id) .'"><i class="flaticon2-graph nav-icon"></i><span class="nav-text">Feature</span></a></li>';

                        //* VIEW
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/view/'.$data->productId->id) .'"><i class="flaticon-eye nav-icon"></i><span class="nav-text">View</span></a></li>';

                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/edit/'.$data->productId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/products/categories/delete/'.$data->productId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.products.products.index');
    }

    public function create()
    {
        $categories = ProductCategory::with('productCategoryId')
            ->where('language_code', '=', 'id')
            ->whereHas('productCategoryId', function($query){
                $query->where('is_active', 1);
            })
            ->get();

        $sort = ProductId::count() + 1;

        return view('backend.pages.products.products.create', compact('sort', 'categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();
        dd($data);

        unset($data['_token']);

        $rules = [
            'banner' => ['required', 'file'],
            'thumbnail' => ['required', 'file'],
            'spesification_image' => ['required', 'file'],
            'id_product_category_id' => ['required'],
            'sort' => [],
            'image' => ['required', 'array']
        ];

        $messages = [];

        $attributes = [
            'banner' => 'Banner',
            'thumbnail' => 'Thumbnail',
            'spesification_image' => 'Spesification Image',
            'id_product_category_id' => 'Product Category',
            'sort' => 'Sort',
            'image' => 'Image'
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

        foreach ($request->image as $key => $image) {
            $rules["image.$key.image"] = ['required', 'image'];

            $attributes["image.$key.image"] = "Image ".$key+1;

            foreach ($image['input'] as $lang => $input) {
                if($lang == 'id'){
                    $rules["image.$key.input.$lang.name"] = ['required'];
                }else{
                    $rules["image.$key.input.$lang.name"] = [];
                }

                $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                $attributes["image.$key.input.$lang.name"] = "$lang_name Name";
            }
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $productId = new ProductId();

            $sort = empty($data['sort']) ? ProductId::count() + 1 : $data['sort'];

            $productId->fill([
                'sort' => $sort,
                'id_product_category_id' => $data['id_product_category_id'],
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

            foreach($data['image'] as $key => $val){
                $imageId = new ProductImageId();

                $imageId->fill([
                    'id_product_id' => $idProductId
                ])->save();

                $idImageId = $imageId->id;

                if ($request->hasFile('image.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('image.'.$key.'.image'),
                        $imageId,
                        'image',
                        "images/products/products/image/{$idImageId}",
                        'image'
                    );
                }

                foreach($val['input'] as $key => $val){
                    $image = new ProductImage();

                    $imageId->fill([
                        'id_product_image_id' => $idImageId,
                        'name' => $val['name']
                    ])->save();
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

            $message = 'Product created successfully';

            DB::commit();
        }catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            $isError = true;

            $err     = $e->errorInfo;

            $message =  $err[2];
        }

        if ($isError == true) {
            return redirect()->back()->with(['error' => $message])->withInput();
        } else {
            return redirect(url('admin-cms/products/products'))
                ->with(['success' => $message]);
        }
    }
}
