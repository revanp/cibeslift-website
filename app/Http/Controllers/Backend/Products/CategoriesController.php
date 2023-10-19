<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategoryId;
use App\Models\ProductTechnologyId;
use App\Models\ProductTechnology;
use App\Models\ProductCategoryIdHasProductTechnologyId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = ProductCategory::with([
                'productCategoryId',
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
                ->addColumn('is_active', function($data){
                    $id = $data->productCategoryId->id;
                    $isActive = $data->productCategoryId->is_active;

                    return view('backend.pages.products.categories.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* USP
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/usp/'.$data->productCategoryId->id) .'"><i class="flaticon2-photograph nav-icon"></i><span class="nav-text">USP</span></a></li>';

                        //* CUSTOMIZATION
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/customizations/'.$data->productCategoryId->id) .'"><i class="flaticon2-cube-1 nav-icon"></i><span class="nav-text">Customization</span></a></li>';

                        //* FEATURE
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/features/'.$data->productCategoryId->id) .'"><i class="flaticon2-graph nav-icon"></i><span class="nav-text">Feature</span></a></li>';

                        //* VIEW
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/view/'.$data->productCategoryId->id) .'"><i class="flaticon-eye nav-icon"></i><span class="nav-text">View</span></a></li>';

                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/categories/edit/'.$data->productCategoryId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/products/categories/delete/'.$data->productCategoryId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.products.categories.index');
    }

    public function view($id)
    {
        $data = ProductCategoryId::with([
            'productCategory',
            'banner',
            'menuIcon',
            'productSummaryImage',
        ])
        ->find($id)
        ->toArray();

        foreach ($data['product_category'] as $key => $val) {
            $data['product_category'][$val['language_code']] = $val;
            unset($data['product_category'][$key]);
        }

        return view('backend.pages.products.categories.view', compact('data'));
    }

    public function create()
    {
        $technologies = ProductTechnology::with('productTechnologyId')->where('language_code', '=', 'id')->whereHas('productTechnologyId', function($query){
            $query->where('is_active', 1);
        })->get();
        $sort = ProductCategoryId::count() + 1;

        return view('backend.pages.products.categories.create', compact('sort', 'technologies'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'banner' => ['required', 'file'],
            'menu_icon' => ['required', 'file'],
            'product_summary_image' => ['file'],
            'product_summary_type' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'banner' => 'Banner',
            'menu_icon' => 'Menu Icon',
            'product_summary_image' => 'Product Summary Image',
            'product_summary_type' => 'Product Summary Type',
            'sort' => 'Sort',
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

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $categoryId = new ProductCategoryId();

            $sort = empty($data['sort']) ? ProductCategoryId::count() + 1 : $data['sort'];

            $categoryId->fill([
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'product_summary_type' => $data['product_summary_type'] ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idCategoryId = $categoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $category = new ProductCategory();

                $input['id_product_category_id'] = $idCategoryId;
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

                $category->fill($input)->save();

                $idCategory = $category->id;
            }

            foreach($data['technologies'] as $key => $val){
                $productCategoryIdHasProductTechnologyId = new ProductCategoryIdHasProductTechnologyId();
                $productCategoryIdHasProductTechnologyId->fill([
                    'id_product_technology_id' => $val,
                    'id_product_category_id' => $idCategoryId,
                ])->save();
            }

            if ($request->hasFile('banner')) {
                $this->storeFile(
                    $request->file('banner'),
                    $categoryId,
                    'banner',
                    "images/products/categories/banner/{$idCategoryId}",
                    'banner'
                );
            }

            if ($request->hasFile('menu_icon')) {
                $this->storeFile(
                    $request->file('menu_icon'),
                    $categoryId,
                    'menuIcon',
                    "images/products/categories/menu_icon/{$idCategoryId}",
                    'menu_icon'
                );
            }

            if ($request->hasFile('product_summary_image')) {
                $this->storeFile(
                    $request->file('product_summary_image'),
                    $categoryId,
                    'productSummaryImage',
                    "images/products/categories/product_summary_image/{$idCategoryId}",
                    'product_summary_image'
                );
            }

            $message = 'Category created successfully';

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            $isError = true;

            $err     = $e->errorInfo;

            $message =  $err[2];
        }

        if ($isError == true) {
            return redirect()->back()->with(['error' => $message]);
        } else {
            return redirect(url('admin-cms/products/categories'))
                ->with(['success' => $message]);
        }
    }

    public function edit($id)
    {
        $data = ProductCategoryId::with([
            'productCategory',
            'productCategoryIdHasProductTechnologyId',
            'banner',
            'menuIcon',
            'productSummaryImage',
        ])
        ->find($id)
        ->toArray();

        foreach ($data['product_category'] as $key => $val) {
            $data['product_category'][$val['language_code']] = $val;
            unset($data['product_category'][$key]);
        }

        $productCategoryIdHasProductTechnologyId = $data['product_category_id_has_product_technology_id'];
        unset($data['product_category_id_has_product_technology_id']);
        foreach($productCategoryIdHasProductTechnologyId as $key => $val){
            $data['product_category_id_has_product_technology_id'][$key] = $val['id_product_technology_id'];
        }

        $technologies = ProductTechnology::with('productTechnologyId')->where('language_code', '=', 'id')->whereHas('productTechnologyId', function($query){
            $query->where('is_active', 1);
        })->get();

        $sort = ProductCategoryId::count() + 1;

        return view('backend.pages.products.categories.edit', compact('data', 'sort', 'technologies'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'banner' => ['file'],
            'menu_icon' => ['file'],
            'product_summary_image' => ['file'],
            'product_summary_type' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'banner' => 'Banner',
            'menu_icon' => 'Menu Icon',
            'product_summary_image' => 'Product Summary Image',
            'product_summary_type' => 'Product Summary Type',
            'sort' => 'Sort',
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

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $categoryId = ProductCategoryId::find($id);

            $sort = empty($data['sort']) ? ProductCategoryId::count() + 1 : $data['sort'];

            $categoryId->fill([
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'product_summary_type' => $data['product_summary_type'] ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idCategoryId = $categoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $category = ProductCategory::where('language_code', $languageCode)->where('id_product_category_id', $id)->first();

                $input['id_product_category_id'] = $idCategoryId;
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

                $category->fill($input)->save();

                $idCategory = $category->id;
            }

            ProductCategoryIdHasProductTechnologyId::where('id_product_category_id', $id)->delete();
            foreach($data['technologies'] as $key => $val){
                $productCategoryIdHasProductTechnologyId = new ProductCategoryIdHasProductTechnologyId();
                $productCategoryIdHasProductTechnologyId->fill([
                    'id_product_technology_id' => $val,
                    'id_product_category_id' => $idCategoryId,
                ])->save();
            }

            if ($request->hasFile('banner')) {
                $this->storeFile(
                    $request->file('banner'),
                    $categoryId,
                    'banner',
                    "images/products/categories/banner/{$idCategoryId}",
                    'banner'
                );
            }

            if ($request->hasFile('menu_icon')) {
                $this->storeFile(
                    $request->file('menu_icon'),
                    $categoryId,
                    'menuIcon',
                    "images/products/categories/menu_icon/{$idCategoryId}",
                    'menu_icon'
                );
            }

            if ($request->hasFile('product_summary_image')) {
                $this->storeFile(
                    $request->file('product_summary_image'),
                    $categoryId,
                    'productSummaryImage',
                    "images/products/categories/product_summary_image/{$idCategoryId}",
                    'product_summary_image'
                );
            }

            $message = 'Category updated successfully';

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            $isError = true;

            $err     = $e->errorInfo;

            $message =  $err[2];
        }

        if ($isError == true) {
            return redirect()->back()->with(['error' => $message]);
        } else {
            return redirect(url('admin-cms/products/categories'))
                ->with(['success' => $message]);
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

                $update = ProductCategoryId::where('id', $id)->update([
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

            $delete = ProductCategoryId::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            $deleteChild = ProductCategory::where('id_product_category_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/products/categories')->with(['success' => 'Product Categories has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
