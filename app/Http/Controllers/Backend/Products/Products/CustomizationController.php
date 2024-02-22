<?php

namespace App\Http\Controllers\Backend\Products\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductCustomization;
use App\Models\ProductCustomizationId;
use App\Models\ProductCustomizationFeature;
use App\Models\ProductCustomizationFeatureId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CustomizationController extends Controller
{
    public function __construct(Request $request)
    {
        $id = $request->route()->parameter('id');

        $check = ProductId::find($id);
        if(empty($check)){
            abort(404);
        }
    }

    public function index($id)
    {
        $datas = ProductCustomization::with(['productCustomizationId'])
            ->where('language_code', 'id')
            ->whereHas('productCustomizationId', function($query) use($id){
                $query->where('id_product_id', $id);
            })
            ->get();

        return view('backend.pages.products.products.customizations.index', compact('id', 'datas'));
    }

    public function create($id)
    {
        return view('backend.pages.products.products.customizations.create', compact('id'));
    }

    public function store($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'image' => ['required']
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image'
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

        try {
            DB::beginTransaction();

            $customizationId = new ProductCustomizationId();

            $customizationId->fill([
                'id_product_id' => $id
            ])->save();

            $idCustomizationId = $customizationId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $customization = new ProductCustomization();

                $input['id_product_customization_id'] = $idCustomizationId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $customization->fill($input)->save();

                $idCustomization = $customization->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $customizationId,
                    'image',
                    "images/products/products/customization/{$idCustomizationId}",
                    'image'
                );
            }

            foreach ($data['feature'] as $key => $val) {
                if ($request->hasFile('feature.'.$key.'.image')) {
                    $featureId = new ProductCustomizationFeatureId();

                    $featureId->fill([
                        'id_product_customization_id' => $idCustomizationId
                    ])->save();

                    $idFeatureId = $featureId->id;

                    foreach ($val['input'] as $languageCode => $inputFeature) {
                        $feature = new ProductCustomizationFeature();

                        $inputFeature['id_product_customization_feature_id'] = $idFeatureId;
                        $inputFeature['language_code'] = $languageCode;

                        if($languageCode != 'id'){
                            $inputFeature['name'] = $data['feature'][$key]['input']['en']['name'] ?? $data['feature'][$key]['input']['id']['name'];
                            $inputFeature['description'] = $data['feature'][$key]['input']['en']['description'] ?? $data['feature'][$key]['input']['id']['description'];
                        }

                        $feature->fill($inputFeature)->save();

                        $idFeature = $feature->id;
                    }
                }

                if ($request->hasFile('feature.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('feature.'.$key.'.image'),
                        $featureId,
                        'image',
                        "images/products/products/customization/feature/{$idFeatureId}",
                        'image'
                    );
                }
            }

            $message = 'Customization created successfully';

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
                'redirect' => url('admin-cms/products/products/customizations/'.$id)
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id, $idFaq)
    {
        $data = ProductCustomizationId::with([
            'productCustomization',
            'image',
            'productCustomizationFeatureId',
            'productCustomizationFeatureId.image',
            'productCustomizationFeatureId.productCustomizationFeature'
        ])
        ->find($idFaq)
        ->toArray();

        foreach ($data['product_customization'] as $key => $val) {
            $data['product_customization'][$val['language_code']] = $val;
            unset($data['product_customization'][$key]);
        }

        foreach ($data['product_customization_feature_id'] as $key => $val) {
            foreach($val['product_customization_feature'] as $key2 => $val2){
                $data['product_customization_feature_id'][$key]['product_customization_feature'][$val2['language_code']] = $val2;
                unset($data['product_customization_feature_id'][$key]['product_customization_feature'][$key2]);
            }
        }

        return view('backend.pages.products.products.customizations.edit', compact('data', 'id'));
    }

    public function update($id, $idCustomization, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'image' => []
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image'
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

        try {
            DB::beginTransaction();

            $customizationId = ProductCustomizationId::find($idCustomization);

            $customizationId->fill([
                'id_product_id' => $id
            ])->save();

            $idCustomizationId = $customizationId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $customization = ProductCustomization::where('id_product_customization_id', $idCustomizationId)->where('language_code', $languageCode)->first();

                $input['id_product_customization_id'] = $idCustomizationId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $customization->fill($input)->save();

                $idCustomization = $customization->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $customizationId,
                    'image',
                    "images/products/products/customization/{$idCustomizationId}",
                    'image'
                );
            }

            foreach ($data['feature'] as $key => $val) {
                if(!empty($val['id'])) {
                    $featureId = ProductCustomizationFeatureId::find($val['id']);
                }else{
                    $featureId = new ProductCustomizationFeatureId();
                }

                $featureId->fill([
                    'id_product_customization_id' => $idCustomizationId
                ])->save();

                $idFeatureId = $featureId->id;

                foreach ($val['input'] as $languageCode => $inputFeature) {
                    if(!empty($val['id'])) {
                        $feature = ProductCustomizationFeature::where('language_code', $languageCode)->where('id_product_customization_feature_id', $val['id'])->first();
                    }else{
                        $feature = new ProductCustomizationFeature();
                    }

                    $inputFeature['id_product_customization_feature_id'] = $idFeatureId;
                    $inputFeature['language_code'] = $languageCode;

                    if($languageCode != 'id'){
                        $inputFeature['name'] = $data['feature'][$key]['input']['en']['name'] ?? $data['feature'][$key]['input']['id']['name'];
                        $inputFeature['description'] = $data['feature'][$key]['input']['en']['description'] ?? $data['feature'][$key]['input']['id']['description'];
                    }

                    $feature->fill($inputFeature)->save();

                    $idFeature = $feature->id;
                }

                if ($request->hasFile('feature.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('feature.'.$key.'.image'),
                        $featureId,
                        'image',
                        "images/products/products/customization/feature/{$idFeatureId}",
                        'image'
                    );
                }
            }

            $message = 'Customization updated successfully';

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
                'redirect' => url('admin-cms/products/products/customizations/'.$id)
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function delete($id, $idCustomization)
    {
        try{
            DB::beginTransaction();

            $delete = ProductCustomizationId::where('id', $idCustomization)->delete();

            $deleteChild = ProductCustomization::where('id_product_customization_id', $idCustomization)->delete();

            DB::commit();

            return redirect('admin-cms/products/products/customizations/'.$id)->with(['success' => 'Customization has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }

    public function deleteFeature($id, $idCustomization, $idFeature)
    {
        try{
            DB::beginTransaction();

            $delete = ProductCustomizationFeatureId::where('id', $idFeature)->delete();
            $deleteChild = ProductCustomizationFeature::where('id_product_customization_feature_id', $idFeature)->delete();

            DB::commit();

            return redirect()->back()->with(['success' => 'Feature has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
