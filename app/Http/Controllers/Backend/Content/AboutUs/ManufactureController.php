<?php

namespace App\Http\Controllers\Backend\Content\AboutUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManufactureId;
use App\Models\Manufacture;
use App\Models\ManufactureIdHasProductId;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManufactureController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = Manufacture::with([
                'manufactureId',
                'manufactureId.image'
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
                ->addColumn('image', function($data){
                    return '<a href="'. $data->manufactureId->image->path .'" target="_BLANK"><img src="'.$data->manufactureId->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('sort', function($data){
                    return $data->manufactureId->sort;
                })
                ->addColumn('year', function($data){
                    return $data->manufactureId->year;
                })
                ->addColumn('is_active', function($data){
                    $id = $data->manufactureId->id;
                    $isActive = $data->manufactureId->is_active;

                    return view('backend.layouts.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/about-us/manufacture/edit/'.$data->manufactureId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/about-us/manufacture/delete/'.$data->manufactureId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.about-us.manufacture.index');
    }

    public function create()
    {
        $sort = ManufactureId::select('sort')->orderBy('sort', 'desc')->first();

        if(!empty($sort)){
            $sort = $sort->sort;
        }

        $products = Product::with([
            'productId'
        ])
        ->where('language_code', 'id')
        ->whereHas('productId', function($query){
            $query->where('level', 1);
        })
        ->get();

        return view('backend.pages.content.about-us.manufacture.create', compact('sort', 'products'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
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

            $manufactureId = new ManufactureId();

            $sort = empty($data['sort']) ? ManufactureId::count() + 1 : $data['sort'];

            $manufactureId->fill([
                // 'location' => $data['location'],
                'is_coming_soon' => !empty($data['is_coming_soon']) ? true : false,
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idManufactureId = $manufactureId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $manufacture = new Manufacture();

                $input['id_manufacture_id'] = $idManufactureId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $manufacture->fill($input)->save();

                $idManufacture = $manufacture->id;
            }

            foreach($data['products'] as $key => $val){
                $manufactureIdHasProductId = new ManufactureIdHasProductId();
                $manufactureIdHasProductId->fill([
                    'id_manufacture_id' => $idManufactureId,
                    'id_product_id' => $val,
                ])->save();
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $manufactureId,
                    'image',
                    "images/about-us/manufacture/image/{$idManufactureId}",
                    'image'
                );
            }

            $message = 'Manufacture created successfully';

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
                'redirect' => url('admin-cms/content/about-us/manufacture')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = ManufactureId::with([
            'image',
            'manufactureIdHasProductId',
            'manufacture'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['manufacture'] as $key => $val) {
            $data['manufacture'][$val['language_code']] = $val;
            unset($data['manufacture'][$key]);
        }

        $productIdHasProductTechnologyId = $data['manufacture_id_has_product_id'];
        unset($data['manufacture_id_has_product_id']);
        foreach($productIdHasProductTechnologyId as $key => $val){
            $data['manufacture_id_has_product_id'][$key] = $val['id_product_id'];
        }

        $sort = ManufactureId::select('sort')->orderBy('sort', 'desc')->first();
        $sort = $sort->sort;

        $products = Product::with([
            'productId'
        ])
        ->where('language_code', 'id')
        ->whereHas('productId', function($query){
            $query->where('level', 1);
        })
        ->get();

        return view('backend.pages.content.about-us.manufacture.edit', compact('data', 'sort', 'products'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => [],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
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

            $manufactureId = ManufactureId::find($id);

            $sort = empty($data['sort']) ? ManufactureId::count() + 1 : $data['sort'];

            $manufactureId->fill([
                'is_coming_soon' => !empty($data['is_coming_soon']) ? true : false,
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idManufactureId = $manufactureId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $manufacture = Manufacture::where('language_code', $languageCode)->where('id_manufacture_id', $id)->first();

                $input['id_manufacture_id'] = $idManufactureId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $manufacture->fill($input)->save();

                $idManufacture = $manufacture->id;
            }

            ManufactureIdHasProductId::where('id_manufacture_id', $id)->delete();
            foreach($data['products'] as $key => $val){
                $manufactureIdHasProductId = new ManufactureIdHasProductId();
                $manufactureIdHasProductId->fill([
                    'id_manufacture_id' => $idManufactureId,
                    'id_product_id' => $val,
                ])->save();
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $manufactureId,
                    'image',
                    "images/about-us/manufacture/image/{$idManufactureId}",
                    'image'
                );
            }

            $message = 'Manufacture created successfully';

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
                'redirect' => url('admin-cms/content/about-us/manufacture')
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

                $update = ManufactureId::where('id', $id)->update([
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

            $delete = ManufactureId::where('id', $id)->delete();
            $deleteChild = Manufacture::where('id_manufacture_id', $id)->delete();
            $deleteChild2 = ManufactureIdHasProductId::where('id_manufacture_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/about-us/manufacture')->with(['success' => 'Manufacture has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
