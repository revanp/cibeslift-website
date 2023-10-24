<?php

namespace App\Http\Controllers\Backend\Products\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductFeature;
use App\Models\ProductFeatureId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class FeaturesController extends Controller
{
    public function index($id, Request $request)
    {
        $datas = ProductFeature::with(['productFeatureId', 'productFeatureId.image'])
            ->where('language_code', 'id')
            ->get();

        return view('backend.pages.products.products.features.index', compact('id', 'datas'));
    }

    public function create($id)
    {
        $sort = ProductFeatureId::where('id_product_id', $id)->count() + 1;

        return view('backend.pages.products.products.features.create', compact('id', 'sort'));
    }

    public function store($id, Request $request)
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
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $featureId = new ProductFeatureId();

            $sort = empty($data['sort']) ? ProductFeatureId::where('id_product_id', $id)->count() + 1 : $data['sort'];

            $featureId->fill([
                'id_product_id' => $id,
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idFeatureId = $featureId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $feature = new ProductFeature();

                $input['id_product_feature_id'] = $idFeatureId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $feature->fill($input)->save();

                $idFeature = $feature->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $featureId,
                    'image',
                    "images/products/products/features/{$id}/image/{$idFeatureId}",
                    'image'
                );
            }

            $message = 'Feature created successfully';

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
            return redirect(url('admin-cms/products/products/features/'.$id))
                ->with(['success' => $message]);
        }
    }

    public function edit($id, $idFeature)
    {
        $data = ProductFeatureId::with([
            'productFeature',
            'image',
        ])
        ->find($idFeature)
        ->toArray();

        foreach ($data['product_feature'] as $key => $val) {
            $data['product_feature'][$val['language_code']] = $val;
            unset($data['product_feature'][$key]);
        }

        $sort = ProductFeatureId::where('id_product_id', $id)->count() + 1;

        return view('backend.pages.products.products.features.edit', compact('data', 'id', 'sort'));
    }

    public function update($id, $idFeature, Request $request)
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
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $featureId = ProductFeatureId::find($idFeature);

            $sort = empty($data['sort']) ? ProductFeatureId::where('id_product_id', $id)->count() + 1 : $data['sort'];

            $featureId->fill([
                'id_product_id' => $id,
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idFeatureId = $featureId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $feature = ProductFeature::where('language_code', $languageCode)->where('id_product_feature_id', $idFeature)->first();

                $input['id_product_feature_id'] = $idFeatureId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $feature->fill($input)->save();

                $usp = $feature->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $featureId,
                    'image',
                    "images/products/products/features/{$id}/image/{$idFeatureId}",
                    'image'
                );
            }

            $message = 'Feature updated successfully';

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
            return redirect(url('admin-cms/products/products/features/'.$id))
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

                $update = ProductFeatureId::where('id', $id)->update([
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

    public function delete($id, $idFeature)
    {
        try{
            DB::beginTransaction();

            $delete = ProductFeatureId::where('id', $idFeature)->update([
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            $deleteChild = ProductFeature::where('id_product_feature_id', $idFeature)->delete();

            DB::commit();

            return redirect('admin-cms/products/products/features/'.$id)->with(['success' => 'Feature has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
