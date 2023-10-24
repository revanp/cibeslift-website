<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategoryId;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductUsp;
use App\Models\ProductUspId;
use App\Models\ProductSpecification;
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
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/products/customizations/'.$data->productId->id) .'"><i class="flaticon2-cube-1 nav-icon"></i><span class="nav-text">Customization</span></a></li>';

                        //* FEATURE
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/products/features/'.$data->productId->id) .'"><i class="flaticon2-graph nav-icon"></i><span class="nav-text">Feature</span></a></li>';

                        //* VIEW
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/products/view/'.$data->productId->id) .'"><i class="flaticon-eye nav-icon"></i><span class="nav-text">View</span></a></li>';

                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/products/edit/'.$data->productId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/products/products/delete/'.$data->productId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
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

        unset($data['_token']);

        $rules = [
            'banner' => ['required', 'file'],
            'thumbnail' => ['required', 'file'],
            'spesification_image' => ['required', 'file'],
            'id_product_category_id' => ['required'],
            'sort' => [],
            'image' => ['required', 'array'],
            'specification.size' => ['required'],
            'specification.installation' => ['required'],
            'specification.power_supply' => ['required'],
            'specification.min_headroom' => ['required'],
            'specification.drive_system' => ['required'],
            'specification.max_number_of_stops' => ['required'],
            'specification.door_configuration' => ['required'],
            'specification.rated_load' => ['required'],
            'specification.speed_max' => ['required'],
            'specification.lift_pit' => ['required'],
            'specification.max_travel' => ['required'],
            'specification.motor_power' => ['required'],

        ];

        $messages = [];

        $attributes = [
            'banner' => 'Banner',
            'thumbnail' => 'Thumbnail',
            'spesification_image' => 'Spesification Image',
            'id_product_category_id' => 'Product Category',
            'sort' => 'Sort',
            'image' => 'Image',
            'specification.size' => 'Size',
            'specification.installation' => 'Installation',
            'specification.power_supply' => 'Power Supply',
            'specification.min_headroom' => 'Min. Headroom',
            'specification.drive_system' => 'Drive System',
            'specification.max_number_of_stops' => 'Max. Number Of Stops',
            'specification.door_configuration' => 'Doors configuration',
            'specification.rated_load' => 'Rated Load',
            'specification.speed_max' => 'Speed Max',
            'specification.lift_pit' => 'Lift Pit',
            'specification.max_travel' => 'Max Travel',
            'specification.motor_power' => 'Motor Power',

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

            $specification = new ProductSpecification();
            $data['specification']['id_product_id'] = $idProductId;

            $specification->fill($data['specification'])->save();

            foreach($data['image'] as $key => $val){
                $imageId = new ProductUspId();

                $imageId->fill([
                    'id_product_id' => $idProductId
                ])->save();

                $idImageId = $imageId->id;

                if ($request->hasFile('image.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('image.'.$key.'.image'),
                        $imageId,
                        'image',
                        "images/products/products/usp/{$idImageId}",
                        'image'
                    );
                }

                foreach($val['input'] as $languageCode2 => $val2){
                    $image = new ProductUsp();

                    $dataImage['id_product_usp_id'] = $idImageId;
                    $dataImage['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataImage['name'] = $data['image'][$key]['input']['en']['name'] ?? $data['image'][$key]['input']['id']['name'];
                        $dataImage['description'] = $data['image'][$key]['input']['en']['description'] ?? $data['image'][$key]['input']['id']['description'];
                    }else{
                        $dataImage['name'] = $val2['name'];
                        $dataImage['description'] = $val2['description'];
                    }

                    $image->fill($dataImage)->save();
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

    public function edit($id)
    {
        $data = ProductId::with([
            'product',
            'productSpecification',
            'banner',
            'spesificationImage',
            'thumbnail',
            'productUspId',
            'productUspId.image',
            'productUspId.productUsp',
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

        $categories = ProductCategory::with('productCategoryId')
            ->where('language_code', '=', 'id')
            ->whereHas('productCategoryId', function($query){
                $query->where('is_active', 1);
            })
            ->get();

        $sort = ProductId::count() + 1;

        return view('backend.pages.products.products.edit', compact('data', 'sort', 'categories'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'banner' => ['file'],
            'thumbnail' => ['file'],
            'spesification_image' => ['file'],
            'id_product_category_id' => ['required'],
            'sort' => [],
            'image' => ['array'],
            'specification.size' => ['required'],
            'specification.installation' => ['required'],
            'specification.power_supply' => ['required'],
            'specification.min_headroom' => ['required'],
            'specification.drive_system' => ['required'],
            'specification.max_number_of_stops' => ['required'],
            'specification.door_configuration' => ['required'],
            'specification.rated_load' => ['required'],
            'specification.speed_max' => ['required'],
            'specification.lift_pit' => ['required'],
            'specification.max_travel' => ['required'],
            'specification.motor_power' => ['required'],

        ];

        $messages = [];

        $attributes = [
            'banner' => 'Banner',
            'thumbnail' => 'Thumbnail',
            'spesification_image' => 'Spesification Image',
            'id_product_category_id' => 'Product Category',
            'sort' => 'Sort',
            'image' => 'Image',
            'specification.size' => 'Size',
            'specification.installation' => 'Installation',
            'specification.power_supply' => 'Power Supply',
            'specification.min_headroom' => 'Min. Headroom',
            'specification.drive_system' => 'Drive System',
            'specification.max_number_of_stops' => 'Max. Number Of Stops',
            'specification.door_configuration' => 'Doors configuration',
            'specification.rated_load' => 'Rated Load',
            'specification.speed_max' => 'Speed Max',
            'specification.lift_pit' => 'Lift Pit',
            'specification.max_travel' => 'Max Travel',
            'specification.motor_power' => 'Motor Power',

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
            $rules["image.$key.image"] = ['image'];

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

            $productId = ProductId::find($id);

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
                $product = Product::where('id_product_id', $id)->where('language_code', $languageCode)->first();

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

            $specification = ProductSpecification::where('id_product_id', $id)->first();
            $data['specification']['id_product_id'] = $idProductId;

            $specification->fill($data['specification'])->save();

            $imageIdOld = [];
            foreach ($data['image'] as $key => $val) {
                if(!empty($val['id'])){
                    $existId = $val['id'];

                    array_push($imageIdOld, $existId);
                }
            }

            if(empty($imageIdOld)){
                ProductUspId::where('id_product_id', $id)->delete();
            }

            foreach($data['image'] as $key => $val){
                if(!empty($val['id'])){
                    $imageId = ProductUspId::find($val['id']);
                }else{
                    $imageId = new ProductUspId();
                }

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

                foreach($val['input'] as $languageCode2 => $val2){
                    if(!empty($val['id'])){
                        $image = ProductUsp::where('language_code', $languageCode2)->where('id_product_usp_id', $val['id'])->first();
                    }else{
                        $image = new ProductUsp();
                    }

                    $dataImage['id_product_usp_id'] = $idImageId;
                    $dataImage['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataImage['name'] = $data['image'][$key]['input']['en']['name'] ?? $data['image'][$key]['input']['id']['name'];
                        $dataImage['description'] = $data['image'][$key]['input']['en']['description'] ?? $data['image'][$key]['input']['id']['description'];
                    }else{
                        $dataImage['name'] = $val2['name'];
                        $dataImage['description'] = $val2['description'];
                    }

                    $image->fill($dataImage)->save();
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
