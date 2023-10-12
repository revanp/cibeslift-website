<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductProperty;
use App\Models\ProductPropertyId;
use App\Models\ProductPropertyValue;
use App\Models\ProductPropertyValueId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class PropertiesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = ProductProperty::with([
                'productPropertyId',
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
                    $id = $data->productPropertyId->id;
                    $isActive = $data->productPropertyId->is_active;

                    return view('backend.pages.products.properties.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* VIEW
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/properties/view/'.$data->productPropertyId->id) .'"><i class="flaticon-eye nav-icon"></i><span class="nav-text">View</span></a></li>';

                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/products/properties/edit/'.$data->productPropertyId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/products/properties/delete/'.$data->productPropertyId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.products.properties.index');
    }

    public function create()
    {
        $sort = ProductPropertyId::count() + 1;

        return view('backend.pages.products.properties.create', compact('sort'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'image' => ['required', 'file'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'sort' => 'Sort',
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

        foreach ($request->value as $key => $input) {
            $rules["value.$key.image"] = ['required'];

            $attributes["value.$key.image"] = $key + 1 ." Image";

            foreach ($input['input'] as $lang2 => $input2) {
                if($lang2 == 'id'){
                    $rules["value.$key.input.$lang2.name"] = ['required'];
                }else{
                    $rules["value.$key.input.$lang2.name"] = [];
                }

                $lang_name = $lang2 == 'id' ? 'Indonesia' : 'English';

                $attributes["value.$key.input.$lang2.name"] = "$lang_name Name Value";
            }
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $propertyId = new ProductPropertyId();

            $sort = empty($data['sort']) ? ProductPropertyId::count() + 1 : $data['sort'];

            $propertyId->fill([
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idPropertyId = $propertyId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $property = new ProductProperty();

                $input['id_product_property_id'] = $idPropertyId;
                $input['language_code'] = $languageCode;

                $property->fill($input)->save();

                $idProperty = $property->id;
            }

            foreach ($data['value'] as $key => $val) {
                $propertyValueId = new ProductPropertyValueId();

                $input['id_product_property_id'] = $idPropertyId;

                $propertyValueId->fill($input)->save();

                $idPropertyValueId = $propertyValueId->id;

                foreach ($val['input'] as $languageCode2 => $input) {
                    $propertyValue = new ProductPropertyValue();

                    $input['id_product_property_value_id'] = $idPropertyValueId;
                    $input['language_code'] = $languageCode2;

                    $propertyValue->fill($input)->save();

                    $idPropertyValue = $propertyValue->id;
                }


                if ($request->hasFile('value.'.$key)) {
                    $this->storeFile(
                        $request->file('value.'.$key.'.image'),
                        $propertyValueId,
                        'image',
                        "images/products/properties/value/image/{$idPropertyValueId}",
                        'image'
                    );
                }
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $propertyId,
                    'image',
                    "images/products/properties/image/{$idPropertyId}",
                    'image'
                );
            }

            $message = 'Property created successfully';

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
            return redirect(url('admin-cms/products/properties'))
                ->with(['success' => $message]);
        }
    }

    public function edit($id)
    {
        $data = ProductPropertyId::with([
            'productProperty',
            'image',
            'productPropertyValueId',
            'productPropertyValueId.image',
            'productPropertyValueId.productPropertyValue',
        ])
        ->find($id)
        ->toArray();

        foreach ($data['product_property'] as $key => $val) {
            $data['product_property'][$val['language_code']] = $val;
            unset($data['product_property'][$key]);
        }

        foreach ($data['product_property_value_id'] as $key => $val) {
            foreach($val['product_property_value'] as $key2 => $val2){
                $data['product_property_value_id'][$key]['product_property_value'][$val2['language_code']] = $val2;

                unset($data['product_property_value_id'][$key]['product_property_value'][$key2]);
            }
        }

        $sort = ProductPropertyId::count() + 1;

        return view('backend.pages.products.properties.edit', compact('data', 'sort'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'image' => ['file'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'sort' => 'Sort',
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

        foreach ($request->value as $key => $input) {
            $rules["value.$key.image"] = [];

            $attributes["value.$key.image"] = $key + 1 ." Image";

            foreach ($input['input'] as $lang2 => $input2) {
                if($lang2 == 'id'){
                    $rules["value.$key.input.$lang2.name"] = ['required'];
                }else{
                    $rules["value.$key.input.$lang2.name"] = [];
                }

                $lang_name = $lang2 == 'id' ? 'Indonesia' : 'English';

                $attributes["value.$key.input.$lang2.name"] = "$lang_name Name Value";
            }
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $propertyId = ProductPropertyId::find($id);

            $sort = empty($data['sort']) ? ProductPropertyId::count() + 1 : $data['sort'];

            $propertyId->fill([
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idPropertyId = $propertyId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $property = ProductProperty::where('id_product_property_id', $id)->where('language_code', $languageCode)->first();

                $input['id_product_property_id'] = $idPropertyId;
                $input['language_code'] = $languageCode;

                $property->fill($input)->save();

                $idProperty = $property->id;
            }

            // DELETE OLD VALUE
            $valueIdOld = [];
            foreach ($data['value'] as $key => $val) {
                if(!empty($val['id'])){
                    $existId = $val['id'];

                    array_push($valueIdOld, $existId);
                }
            }

            if(empty($valueIdOld)){
                ProductPropertyValueId::where('id_product_property_id', $idPropertyId)->delete();
            }else{
                ProductPropertyValueId::whereNotIn('id', $valueIdOld)->delete();
            }

            foreach ($data['value'] as $key => $val) {
                if(!empty($val['id'])){
                    $propertyValueId = ProductPropertyValueId::find($val['id']);
                }else{
                    $propertyValueId = new ProductPropertyValueId();
                }

                $input['id_product_property_id'] = $idPropertyId;

                $propertyValueId->fill($input)->save();

                $idPropertyValueId = $propertyValueId->id;

                foreach ($val['input'] as $languageCode2 => $input) {
                    if(!empty($val['id'])){
                        $propertyValue = ProductPropertyValue::where('language_code', $languageCode2)->where('id_product_property_value_id', $idPropertyValueId)->first();
                    }else{
                        $propertyValue = new ProductPropertyValue();
                    }

                    $input['id_product_property_value_id'] = $idPropertyValueId;
                    $input['language_code'] = $languageCode2;

                    $propertyValue->fill($input)->save();

                    $idPropertyValue = $propertyValue->id;
                }


                if ($request->hasFile('value.'.$key)) {
                    $this->storeFile(
                        $request->file('value.'.$key.'.image'),
                        $propertyValueId,
                        'image',
                        "images/products/properties/value/image/{$idPropertyValueId}",
                        'image'
                    );
                }
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $propertyId,
                    'image',
                    "images/products/properties/image/{$idPropertyId}",
                    'image'
                );
            }

            $message = 'Property updated successfully';

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
            return redirect(url('admin-cms/products/properties'))
                ->with(['success' => $message]);
        }
    }
}
