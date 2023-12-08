<?php

namespace App\Http\Controllers\Backend\Products\Installations;

use App\Http\Controllers\Controller;
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

class MasterController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $category = $request->category;

            if($category == 'size'){
                $data = ProductInstallationSize::with([
                    'productInstallationSizeId'
                ])
                ->where('language_code', 'id');
            }else if($category == 'floor_size'){
                $data = ProductInstallationFloorSize::with([
                    'productInstallationFloorSizeId'
                ])
                ->where('language_code', 'id');
            }else if($category == 'area'){
                $data = ProductInstallationArea::with([
                    'productInstallationAreaId'
                ])
                ->where('language_code', 'id');
            }else if($category == 'location'){
                $data = ProductInstallationLocation::with([
                    'productInstallationLocationId'
                ])
                ->where('language_code', 'id');
            }else if($category == 'color'){
                $data = ProductInstallationColor::with([
                    'productInstallationColorId'
                ])
                ->where('language_code', 'id');
            }

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
                ->addColumn('action', function($data) use($category){
                    if($category == 'size'){
                        $id = $data->productInstallationSizeId->id;
                    }else if($category == 'floor_size'){
                        $id = $data->productInstallationFloorSizeId->id;
                    }else if($category == 'area'){
                        $id = $data->productInstallationAreaId->id;
                    }else if($category == 'location'){
                        $id = $data->productInstallationLocationId->id;
                    }else if($category == 'color'){
                        $id = $data->productInstallationColorId->id;
                    }

                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link btn-edit" href="'. url('admin-cms/products/installations/master/edit/'.$id) .'" data-category="'.$category.'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/products/installations/master/delete/'. $category .'/'.$id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['level', 'image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.products.installations.master.index');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'category' => ['required']
        ];

        $messages = [];

        $attributes = [
            'category' => 'Category'
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
            }else{
                $rules["input.$lang.name"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
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

        try {
            DB::beginTransaction();

            $category = $data['category'] ?? null;
            if($category == 'size'){
                $masterId = new ProductInstallationSizeId();
                $foreignKey = 'id_product_installation_size_id';
            }else if($category == 'floor_size'){
                $masterId = new ProductInstallationFloorSizeId();
                $foreignKey = 'id_product_installation_floor_size_id';
            }else if($category == 'area'){
                $masterId = new ProductInstallationAreaId();
                $foreignKey = 'id_product_installation_area_id';
            }else if($category == 'location'){
                $masterId = new ProductInstallationLocationId();
                $foreignKey = 'id_product_installation_location_id';
            }else if($category == 'color'){
                $masterId = new ProductInstallationColorId();
                $foreignKey = 'id_product_installation_color_id';
            }

            $masterId->fill([])->save();

            $idMasterId = $masterId->id;

            foreach ($data['input'] as $languageCode => $input) {
                if($category == 'size'){
                    $master = new ProductInstallationSize();
                }else if($category == 'floor_size'){
                    $master = new ProductInstallationFloorSize();
                }else if($category == 'area'){
                    $master = new ProductInstallationArea();
                }else if($category == 'location'){
                    $master = new ProductInstallationLocation();
                }else if($category == 'color'){
                    $master = new ProductInstallationColor();
                }

                $input[$foreignKey] = $idMasterId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                }else{
                    $input['name'] = $data['input']['id']['name'];
                }

                $master->fill($input)->save();

                $idMaster = $master->id;
            }

            $message = 'Master created successfully';

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
                'redirect' => url('admin-cms/products/installations/master')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id, Request $request)
    {
        $category = $request->category;

        if($category == 'size'){
            $data = ProductInstallationSizeId::with([
                'productInstallationSize'
            ])
            ->find($id)
            ->toArray();

            foreach ($data['product_installation_size'] as $key => $val) {
                $data['child'][$val['language_code']] = $val;
            }

            unset($data['product_installation_size']);
        }else if($category == 'floor_size'){
            $data = ProductInstallationFloorSizeId::with([
                'productInstallationFloorSize'
            ])
            ->find($id)
            ->toArray();

            foreach ($data['product_installation_floor_size'] as $key => $val) {
                $data['child'][$val['language_code']] = $val;
            }

            unset($data['product_installation_floor_size']);
        }else if($category == 'area'){
            $data = ProductInstallationAreaId::with([
                'productInstallationArea'
            ])
            ->find($id)
            ->toArray();

            foreach ($data['product_installation_area'] as $key => $val) {
                $data['child'][$val['language_code']] = $val;
            }

            unset($data['product_installation_area']);
        }else if($category == 'location'){
            $data = ProductInstallationLocationId::with([
                'productInstallationLocation'
            ])
            ->find($id)
            ->toArray();

            foreach ($data['product_installation_location'] as $key => $val) {
                $data['child'][$val['language_code']] = $val;
            }

            unset($data['product_installation_location']);
        }else if($category == 'color'){
            $data = ProductInstallationColorId::with([
                'productInstallationColor'
            ])
            ->find($id)
            ->toArray();

            foreach ($data['product_installation_color'] as $key => $val) {
                $data['child'][$val['language_code']] = $val;
            }

            unset($data['product_installation_color']);
        }

        $data['category'] = $category;

        return $data;
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'category' => ['required']
        ];

        $messages = [];

        $attributes = [
            'category' => 'Category'
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
            }else{
                $rules["input.$lang.name"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
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

        try {
            DB::beginTransaction();

            $category = $data['category'] ?? null;
            if($category == 'size'){
                $masterId = ProductInstallationSizeId::find($id);
                $foreignKey = 'id_product_installation_size_id';
            }else if($category == 'floor_size'){
                $masterId = ProductInstallationFloorSizeId::find($id);
                $foreignKey = 'id_product_installation_floor_size_id';
            }else if($category == 'area'){
                $masterId = ProductInstallationAreaId::find($id);
                $foreignKey = 'id_product_installation_area_id';
            }else if($category == 'location'){
                $masterId = ProductInstallationLocationId::find($id);
                $foreignKey = 'id_product_installation_location_id';
            }else if($category == 'color'){
                $masterId = ProductInstallationColorId::find($id);
                $foreignKey = 'id_product_installation_color_id';
            }

            $masterId->fill([])->save();

            $idMasterId = $masterId->id;

            foreach ($data['input'] as $languageCode => $input) {
                if($category == 'size'){
                    $master = ProductInstallationSize::where($foreignKey, $id)->where('language_code', $languageCode)->first();
                }else if($category == 'floor_size'){
                    $master = ProductInstallationFloorSize::where($foreignKey, $id)->where('language_code', $languageCode)->first();
                }else if($category == 'area'){
                    $master = ProductInstallationArea::where($foreignKey, $id)->where('language_code', $languageCode)->first();
                }else if($category == 'location'){
                    $master = ProductInstallationLocation::where($foreignKey, $id)->where('language_code', $languageCode)->first();
                }else if($category == 'color'){
                    $master = ProductInstallationColor::where($foreignKey, $id)->where('language_code', $languageCode)->first();
                }

                $input[$foreignKey] = $idMasterId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                }else{
                    $input['name'] = $data['input']['id']['name'];
                }

                $master->fill($input)->save();

                $idMaster = $master->id;
            }

            $message = 'Master updated successfully';

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
                'redirect' => url('admin-cms/products/installations/master')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function delete($category, $id)
    {
        try{
            DB::beginTransaction();

            if($category == 'size'){
                $parent = ProductInstallationSizeId::where('id', $id)->delete();
                $child = ProductInstallationSize::where('id_product_installation_size_id', $id)->delete();
            }else if($category == 'floor_size'){
                $parent = ProductInstallationFloorSizeId::where('id', $id)->delete();
                $child = ProductInstallationFloorSize::where('id_product_installation_floor_size_id', $id)->delete();
            }else if($category == 'area'){
                $parent = ProductInstallationAreaId::where('id', $id)->delete();
                $child = ProductInstallationArea::where('id_product_installation_area_id', $id)->delete();
            }else if($category == 'location'){
                $parent = ProductInstallationLocationId::where('id', $id)->delete();
                $child = ProductInstallationLocation::where('id_product_installation_location_id', $id)->delete();
            }else if($category == 'color'){
                $parent = ProductInstallationColorId::where('id', $id)->delete();
                $child = ProductInstallationColor::where('id_product_installation_color_id', $id)->delete();
            }

            DB::commit();

            return redirect('admin-cms/products/installations/master')->with(['success' => 'Master Data has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
