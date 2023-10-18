<?php

namespace App\Http\Controllers\Backend\Products\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ProductCategoryId;
use App\Models\ProductCategoryUsp;
use App\Models\ProductCategoryUspId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class UspController extends Controller
{
    public function index($id, Request $request)
    {
        $datas = ProductCategoryUsp::with(['productCategoryUspId', 'productCategoryUspId.image'])
            ->where('language_code', 'id')
            ->get();

        return view('backend.pages.products.categories.usp.index', compact('id', 'datas'));
    }

    public function create($id)
    {
        $sort = ProductCategoryUspId::where('id_product_category_id', $id)->count() + 1;

        return view('backend.pages.products.categories.usp.create', compact('id', 'sort'));
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

            $uspId = new ProductCategoryUspId();

            $sort = empty($data['sort']) ? ProductCategoryUspId::where('id_product_category_id', $id)->count() + 1 : $data['sort'];

            $uspId->fill([
                'id_product_category_id' => $id,
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idUspId = $uspId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $usp = new ProductCategoryUsp();

                $input['id_product_category_usp_id'] = $idUspId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $usp->fill($input)->save();

                $usp = $usp->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $uspId,
                    'image',
                    "images/products/categories/usp/{$id}/image/{$idUspId}",
                    'image'
                );
            }

            $message = 'USP created successfully';

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
            return redirect(url('admin-cms/products/categories/usp/'.$id))
                ->with(['success' => $message]);
        }
    }

    public function edit($id, $idUsp)
    {
        $data = ProductCategoryUspId::with([
            'productCategoryUsp',
            'image',
        ])
        ->find($idUsp)
        ->toArray();

        foreach ($data['product_category_usp'] as $key => $val) {
            $data['product_category_usp'][$val['language_code']] = $val;
            unset($data['product_category_usp'][$key]);
        }

        $sort = ProductCategoryUspId::where('id_product_category_id', $id)->count() + 1;

        return view('backend.pages.products.categories.usp.edit', compact('data', 'id', 'sort'));
    }

    public function update($id, $idUsp, Request $request)
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

            $uspId = ProductCategoryUspId::find($idUsp);

            $sort = empty($data['sort']) ? ProductCategoryUspId::where('id_product_category_id', $id)->count() + 1 : $data['sort'];

            $uspId->fill([
                'id_product_category_id' => $id,
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idUspId = $uspId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $usp = ProductCategoryUsp::where('language_code', $languageCode)->where('id_product_category_usp_id', $idUsp)->first();

                $input['id_product_category_usp_id'] = $idUspId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $usp->fill($input)->save();

                $usp = $usp->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $uspId,
                    'image',
                    "images/products/categories/usp/{$id}/image/{$idUspId}",
                    'image'
                );
            }

            $message = 'USP updated successfully';

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
            return redirect(url('admin-cms/products/categories/usp/'.$id))
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

                $update = ProductCategoryUspId::where('id', $id)->update([
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

    public function delete($id, $idUsp)
    {
        try{
            DB::beginTransaction();

            $delete = ProductCategoryUspId::where('id', $idUsp)->update([
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            $deleteChild = ProductCategoryUsp::where('id_product_category_usp_id', $idUsp)->delete();

            DB::commit();

            return redirect('admin-cms/products/categories/usp/'.$id)->with(['success' => 'USP has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
