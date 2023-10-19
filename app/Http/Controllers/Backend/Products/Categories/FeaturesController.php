<?php

namespace App\Http\Controllers\Backend\Products\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategoryId;
use App\Models\ProductCategoryFeature;
use App\Models\ProductCategoryFeatureId;
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
        $datas = ProductCategoryFeature::with(['productCategoryFeatureId', 'productCategoryFeatureId.image'])
            ->where('language_code', 'id')
            ->get();

        return view('backend.pages.products.categories.features.index', compact('id', 'datas'));
    }

    public function create($id)
    {
        $sort = ProductCategoryFeatureId::where('id_product_category_id', $id)->count() + 1;

        return view('backend.pages.products.categories.features.create', compact('id', 'sort'));
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

            $featureId = new ProductCategoryFeatureId();

            $sort = empty($data['sort']) ? ProductCategoryFeatureId::where('id_product_category_id', $id)->count() + 1 : $data['sort'];

            $featureId->fill([
                'id_product_category_id' => $id,
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idFeatureId = $featureId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $feature = new ProductCategoryFeature();

                $input['id_product_category_feature_id'] = $idFeatureId;
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
                    "images/products/categories/features/{$id}/image/{$idFeatureId}",
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
            return redirect(url('admin-cms/products/categories/features/'.$id))
                ->with(['success' => $message]);
        }
    }

    public function edit($id, $idFeature)
    {
        $data = ProductCategoryFeatureId::with([
            'productCategoryFeature',
            'image',
        ])
        ->find($idFeature)
        ->toArray();

        foreach ($data['product_category_feature'] as $key => $val) {
            $data['product_category_feature'][$val['language_code']] = $val;
            unset($data['product_category_feature'][$key]);
        }

        $sort = ProductCategoryFeatureId::where('id_product_category_id', $id)->count() + 1;

        return view('backend.pages.products.categories.features.edit', compact('data', 'id', 'sort'));
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

            $featureId = ProductCategoryFeatureId::find($idFeature);

            $sort = empty($data['sort']) ? ProductCategoryFeatureId::where('id_product_category_id', $id)->count() + 1 : $data['sort'];

            $featureId->fill([
                'id_product_category_id' => $id,
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idFeatureId = $featureId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $feature = ProductCategoryFeature::where('language_code', $languageCode)->where('id_product_category_feature_id', $idFeature)->first();

                $input['id_product_category_feature_id'] = $idFeatureId;
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
                    "images/products/categories/features/{$id}/image/{$idFeatureId}",
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
            return redirect(url('admin-cms/products/categories/features/'.$id))
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

                $update = ProductCategoryFeatureId::where('id', $id)->update([
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

            $delete = ProductCategoryFeatureId::where('id', $idFeature)->update([
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            $deleteChild = ProductCategoryFeature::where('id_product_category_feature_id', $idFeature)->delete();

            DB::commit();

            return redirect('admin-cms/products/categories/features/'.$id)->with(['success' => 'Feature has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
