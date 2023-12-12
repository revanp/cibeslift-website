<?php

namespace App\Http\Controllers\Backend\Products\Installations;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

# MODELS
use App\Models\ProductInstallationArea;
use App\Models\ProductInstallationAreaId;
use App\Models\ProductInstallationColor;
use App\Models\ProductInstallationColorId;
use App\Models\ProductInstallationFloorSize;
use App\Models\ProductInstallationFloorSizeId;
use App\Models\ProductInstallationLocation;
use App\Models\ProductInstallationLocationId;
use App\Models\ProductInstallationSize;
use App\Models\ProductInstallationSizeId;
use App\Models\ProductInstallation;
use App\Models\ProductInstallationId;

class InstallationsController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = ProductInstallation::with([
                'productInstallationId',
                'productInstallationId.productId',
                'productInstallationId.productId.product' => function($query){
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
                ->addColumn('product', function($data){
                    return $data->productInstallationId->productId->product[0]->name;
                })
                ->addColumn('is_active', function($data){
                    $id = $data->productInstallationId->id;
                    $isActive = $data->productInstallationId->is_active;

                    return view('backend.pages.products.products.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* VIEW
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/installations/installations/view/'.$data->productInstallationId->id) .'"><i class="flaticon-eye nav-icon"></i><span class="nav-text">View</span></a></li>';

                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/installations/installations/edit/'.$data->productInstallationId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/products/installations/installations/delete/'.$data->productInstallationId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['is_active', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.products.installations.installations.index');
    }

    public function create()
    {
        $products = Product::with([
            'productId'
        ])
        ->whereHas('productId', function($query){
            $query->where('have_a_child', false);
        })
        ->where('language_code', 'id')
        ->get();

        $size = ProductInstallationSize::where('language_code', 'id')
        ->get();

        $floorSize = ProductInstallationFloorSize::where('language_code', 'id')
        ->get();

        $area = ProductInstallationArea::where('language_code', 'id')
        ->get();

        $location = ProductInstallationLocation::where('language_code', 'id')
        ->get();

        $color = ProductInstallationColor::where('language_code', 'id')
        ->get();

        return view('backend.pages.products.installations.installations.create', compact('products', 'size', 'floorSize', 'area', 'location', 'color'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'thumbnail' => ['required'],
            'id_product_id' => ['required'],
            'id_product_installation_size_id' => ['required'],
            'id_product_installation_floor_size_id' => ['required'],
            'id_product_installation_area_id' => ['required'],
            'id_product_installation_location_id' => ['required'],
            'id_product_installation_color_id' => ['required'],
            'location' => [],
            'number_of_stops' => [],
            'installation_date' => ['required']
        ];

        $messages = [];

        $attributes = [
            'thumbnail' => 'Thumbnail',
            'id_product_id' => 'Product',
            'id_product_installation_size_id' => 'Size',
            'id_product_installation_floor_size_id' => 'Floor Size',
            'id_product_installation_area_id' => 'Area',
            'id_product_installation_location_id' => 'Location',
            'id_product_installation_color_id' => 'Color',
            'location' => 'Location (City)',
            'number_of_stops' => 'Number of Stops',
            'installation_date' => 'Installation Date',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
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
        }

        $isError = false;

        try{
            DB::beginTransaction();

            $installationId = new ProductInstallationId();

            $installationId->fill([
                'id_product_id' => $data['id_product_id'],
                'id_product_installation_size_id' => $data['id_product_installation_size_id'],
                'id_product_installation_floor_size_id' => $data['id_product_installation_floor_size_id'],
                'id_product_installation_area_id' => $data['id_product_installation_area_id'],
                'id_product_installation_location_id' => $data['id_product_installation_location_id'],
                'id_product_installation_color_id' => $data['id_product_installation_color_id'],
                'location' => $data['location'] ?? null,
                'number_of_stops' => $data['number_of_stops'] ?? null,
                'installation_date' => $data['installation_date'] ?? null,
            ])->save();

            $idInstallationId = $installationId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $installation = new ProductInstallation();

                $input['id_product_installation_id'] = $idInstallationId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $input['slug'] = Str::slug($input['name']);

                $installation->fill($input)->save();

                $idInstallation = $installation->id;
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $installationId,
                    'thumbnail',
                    "images/products/installations/installations/thumbnail/{$idInstallationId}",
                    'thumbnail'
                );
            }

            foreach($data['image'] as $key => $val){
                if ($request->hasFile('image.'.$key)) {
                    $this->storeFile(
                        $request->file('image.'.$key),
                        $installationId,
                        'image',
                        "images/products/installations/installations/image/{$idInstallationId}",
                        'image'
                    );
                }
            }

            $message = 'Installation created successfully';

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
                'redirect' => url('admin-cms/products/installations/installations')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = ProductInstallationId::with([
            'productInstallation',
            'thumbnail',
            'image',
        ])
        ->find($id)
        ->toArray();

        foreach ($data['product_installation'] as $key => $val) {
            $data['product_installation'][$val['language_code']] = $val;
            unset($data['product_installation'][$key]);
        }

        $products = Product::with([
            'productId'
        ])
        ->whereHas('productId', function($query){
            $query->where('have_a_child', false);
        })
        ->where('language_code', 'id')
        ->get();

        $size = ProductInstallationSize::where('language_code', 'id')
        ->get();

        $floorSize = ProductInstallationFloorSize::where('language_code', 'id')
        ->get();

        $area = ProductInstallationArea::where('language_code', 'id')
        ->get();

        $location = ProductInstallationLocation::where('language_code', 'id')
        ->get();

        $color = ProductInstallationColor::where('language_code', 'id')
        ->get();

        return view('backend.pages.products.installations.installations.edit', compact('data', 'products', 'size', 'floorSize', 'area', 'location', 'color'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'thumbnail' => [],
            'id_product_id' => ['required'],
            'id_product_installation_size_id' => ['required'],
            'id_product_installation_floor_size_id' => ['required'],
            'id_product_installation_area_id' => ['required'],
            'id_product_installation_location_id' => ['required'],
            'id_product_installation_color_id' => ['required'],
            'location' => [],
            'number_of_stops' => [],
            'installation_date' => ['required']
        ];

        $messages = [];

        $attributes = [
            'thumbnail' => 'Thumbnail',
            'id_product_id' => 'Product',
            'id_product_installation_size_id' => 'Size',
            'id_product_installation_floor_size_id' => 'Floor Size',
            'id_product_installation_area_id' => 'Area',
            'id_product_installation_location_id' => 'Location',
            'id_product_installation_color_id' => 'Color',
            'location' => 'Location (City)',
            'number_of_stops' => 'Number of Stops',
            'installation_date' => 'Installation Date',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
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
        }

        $isError = false;

        try{
            DB::beginTransaction();

            $installationId = ProductInstallationId::find($id);

            $installationId->fill([
                'id_product_id' => $data['id_product_id'],
                'id_product_installation_size_id' => $data['id_product_installation_size_id'],
                'id_product_installation_floor_size_id' => $data['id_product_installation_floor_size_id'],
                'id_product_installation_area_id' => $data['id_product_installation_area_id'],
                'id_product_installation_location_id' => $data['id_product_installation_location_id'],
                'id_product_installation_color_id' => $data['id_product_installation_color_id'],
                'location' => $data['location'] ?? null,
                'number_of_stops' => $data['number_of_stops'] ?? null,
                'installation_date' => $data['installation_date'] ?? null,
            ])->save();

            $idInstallationId = $installationId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $installation = ProductInstallation::where('language_code', $languageCode)->where('id_product_installation_id', $id)->first();

                $input['id_product_installation_id'] = $idInstallationId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $input['slug'] = Str::slug($input['name']);

                $installation->fill($input)->save();

                $idInstallation = $installation->id;
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $installationId,
                    'thumbnail',
                    "images/products/installations/installations/thumbnail/{$idInstallationId}",
                    'thumbnail'
                );
            }

            if(!empty($data['image'])){
                foreach($data['image'] as $key => $val){
                    if ($request->hasFile('image.'.$key)) {
                        if(!empty($data['image_id'][$key])){
                            $this->storeFileHasMany(
                                $request->file('image.'.$key),
                                $installationId,
                                'image',
                                "images/products/installations/installations/image/{$idInstallationId}",
                                'image',
                                $data['image_id'][$key]
                            );
                        }else{
                            $this->storeFileHasMany(
                                $request->file('image.'.$key),
                                $installationId,
                                'image',
                                "images/products/installations/installations/image/{$idInstallationId}",
                                'image'
                            );
                        }
                    }
                }
            }

            $message = 'Installation updated successfully';

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
                'redirect' => url('admin-cms/products/installations/installations')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }
}
