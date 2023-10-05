<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategoryId;
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
            'image',
            'thumbnail',
            'banner',
            'fileIcon',
            'videoThumbnail',
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
        $sort = ProductCategoryId::count() + 1;

        return view('backend.pages.products.categories.create', compact('sort'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'thumbnail' => ['required', 'file'],
            'banner' => ['required', 'file'],
            'file_icon' => ['required', 'file'],
            'video_thumbnail' => ['required', 'file'],
            'image' => ['required', 'array'],
            'image.*' => ['file'],
            'video_url' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'thumbnail' => 'Thumbnail',
            'banner' => 'Banner',
            'file_icon' => 'File Icon',
            'video_thumbnail' => 'Video Thumbnail',
            'image' => 'Image',
            'image.*' => 'Image',
            'video_url' => 'Video URL',
            'sort' => 'Sort',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = ['required'];
                $rules["input.$lang.post_description"] = [];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = [];
                $rules["input.$lang.post_description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.post_title"] = "$lang_name Post Title";
            $attributes["input.$lang.post_description"] = "$lang_name Post Description";
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
                'is_self_design' => !empty($data['is_self_design']) ? true : false,
                'video_url' => $data['video_url'] ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idCategoryId = $categoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $category = new ProductCategory();

                $input['id_product_category_id'] = $idCategoryId;
                $input['slug'] = Str::slug($input['name']);
                $input['language_code'] = $languageCode;

                $category->fill($input)->save();

                $idCategory = $category->id;
            }

            if ($request->hasFile('image')) {
                foreach($request->file('image') as $image){
                    $this->storeFile(
                        $image,
                        $categoryId,
                        'image',
                        "images/products/categories/image/{$idCategoryId}",
                        'image'
                    );
                }
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $categoryId,
                    'thumbnail',
                    "images/products/categories/thumbnail/{$idCategoryId}",
                    'thumbnail'
                );
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

            if ($request->hasFile('file_icon')) {
                $this->storeFile(
                    $request->file('file_icon'),
                    $categoryId,
                    'fileIcon',
                    "images/products/categories/file_icon/{$idCategoryId}",
                    'file_icon'
                );
            }

            if ($request->hasFile('video_thumbnail')) {
                $this->storeFile(
                    $request->file('video_thumbnail'),
                    $categoryId,
                    'videoThumbnail',
                    "images/products/categories/video_thumbnail/{$idCategoryId}",
                    'video_thumbnail'
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
            'image',
            'thumbnail',
            'banner',
            'fileIcon',
            'videoThumbnail',
        ])
        ->find($id)
        ->toArray();

        foreach ($data['product_category'] as $key => $val) {
            $data['product_category'][$val['language_code']] = $val;
            unset($data['product_category'][$key]);
        }

        $sort = ProductCategoryId::count() + 1;

        return view('backend.pages.products.categories.edit', compact('data', 'sort'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'thumbnail' => ['file'],
            'banner' => ['file'],
            'file_icon' => ['file'],
            'video_thumbnail' => ['file'],
            'image' => ['array'],
            'image.*' => ['file'],
            'video_url' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'thumbnail' => 'Thumbnail',
            'banner' => 'Banner',
            'file_icon' => 'File Icon',
            'video_thumbnail' => 'Video Thumbnail',
            'image' => 'Image',
            'image.*' => 'Image',
            'video_url' => 'Video URL',
            'sort' => 'Sort',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = ['required'];
                $rules["input.$lang.post_description"] = [];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = [];
                $rules["input.$lang.post_description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.post_title"] = "$lang_name Post Title";
            $attributes["input.$lang.post_description"] = "$lang_name Post Description";
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
                'is_self_design' => !empty($data['is_self_design']) ? true : false,
                'video_url' => $data['video_url'] ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idCategoryId = $categoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $category = ProductCategory::where('id_product_category_id', $id)->where('language_code', $languageCode)->first();

                $input['id_product_category_id'] = $idCategoryId;
                $input['slug'] = Str::slug($input['name']);
                $input['language_code'] = $languageCode;

                $category->fill($input)->save();

                $idCategory = $category->id;
            }

            if ($request->hasFile('image')) {
                foreach($request->file('image') as $image){
                    $this->storeFile(
                        $image,
                        $categoryId,
                        'image',
                        "images/products/categories/image/{$idCategoryId}",
                        'image'
                    );
                }
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $categoryId,
                    'thumbnail',
                    "images/products/categories/thumbnail/{$idCategoryId}",
                    'thumbnail'
                );
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

            if ($request->hasFile('file_icon')) {
                $this->storeFile(
                    $request->file('file_icon'),
                    $categoryId,
                    'fileIcon',
                    "images/products/categories/file_icon/{$idCategoryId}",
                    'file_icon'
                );
            }

            if ($request->hasFile('video_thumbnail')) {
                $this->storeFile(
                    $request->file('video_thumbnail'),
                    $categoryId,
                    'videoThumbnail',
                    "images/products/categories/video_thumbnail/{$idCategoryId}",
                    'video_thumbnail'
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
