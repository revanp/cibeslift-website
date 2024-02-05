<?php

namespace App\Http\Controllers\Backend\Products\Products\Customization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductCustomization;
use App\Models\ProductCustomizationId;
use App\Models\ProductCustomizationFeature;
use App\Models\ProductCustomizationFeatureId;
use App\Models\ProductCustomizationOption;
use App\Models\ProductCustomizationOptionId;
use App\Models\ProductCustomizationOptionVariation;
use App\Models\ProductCustomizationOptionVariationId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
    public function __construct(Request $request)
    {
        $id = $request->route()->parameter('id');

        $check = ProductId::find($id);
        if(empty($check)){
            abort(404);
        }

        $idCustomization = $request->route()->parameter('idCustomization');

        $check2 = ProductCustomizationId::find($idCustomization);
        if(empty($check2)){
            abort(404);
        }
    }

    public function index($id, $idCustomization)
    {
        $datas = ProductCustomizationOption::with(['productCustomizationOptionId'])
            ->where('language_code', 'id')
            ->whereHas('productCustomizationOptionId', function($query) use($idCustomization){
                $query->where('id_product_customization_id', $idCustomization);
            })
            ->get();

        return view('backend.pages.products.products.customizations.options.index', compact('id', 'idCustomization', 'datas'));
    }

    public function create($id, $idCustomization)
    {
        $parents = ProductCustomizationOption::with(['productCustomizationOptionId'])
            ->where('language_code', 'en')
            ->whereHas('productCustomizationOptionId', function($query) use($idCustomization){
                $query->where('id_product_customization_id', $idCustomization);
                $query->whereNull('parent_id');
            })
            ->get();

        return view('backend.pages.products.products.customizations.options.create', compact('id', 'idCustomization', 'parents'));
    }

    public function store($id, $idCustomization, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [

        ];

        $messages = [];

        $attributes = [

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

        if(empty($data['have_a_child'])){
            foreach($request->variation as $key => $val){
                $rules['variation.'.$key.'.image'] = ['required'];

                $attributes['variation.'.$key.'.image'] = 'Variation Image ' . $key + 1;

                foreach($val['input'] as $lang => $input2){
                    if($lang == 'id'){
                        $rules["variation.". $key . ".input.". $lang.".name"] = ['required'];
                    }else{
                        $rules["variation.". $key . ".input.". $lang.".name"] = [];
                    }

                    $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                    $attributes["variation.". $key . ".input.". $lang.".name"] = "Variation $lang_name Name " . $key + 1;
                }
            }
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

            $optionId = new ProductCustomizationOptionId();

            $optionId->fill([
                'id_product_customization_id' => $idCustomization,
                'parent_id' => $data['parent_id'] ?? null,
            ])->save();

            $idOptionId = $optionId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $option = new ProductCustomizationOption();

                $input['id_product_customization_option_id'] = $idOptionId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                }

                $option->fill($input)->save();

                $idOption = $option->id;
            }

            foreach($data['variation'] as $key => $val){
                $variationId = new ProductCustomizationOptionVariationId();

                $variationId->fill([
                    'id_product_customization_option_id' => $idOptionId
                ])->save();

                $idVariationId = $variationId->id;

                if ($request->hasFile('variation.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('variation.'.$key.'.image'),
                        $variationId,
                        'image',
                        "images/products/products/customization/option/variation/{$idVariationId}",
                        'image'
                    );
                }

                foreach($val['input'] as $languageCode2 => $val2){
                    $variation = new ProductCustomizationOptionVariation();

                    $dataVariation['id_product_customization_option_variation_id'] = $idVariationId;
                    $dataVariation['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataVariation['name'] = $data['variation'][$key]['input']['en']['name'] ?? $data['variation'][$key]['input']['id']['name'];
                    }else{
                        $dataVariation['name'] = $val2['name'];
                    }

                    $variation->fill($dataVariation)->save();
                }
            }

            $message = 'Option created successfully';

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
                'redirect' => url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization)
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id, $idCustomization, $idOption)
    {
        $parents = ProductCustomizationOption::with(['productCustomizationOptionId'])
            ->where('language_code', 'en')
            ->whereHas('productCustomizationOptionId', function($query) use($idCustomization){
                $query->where('id_product_customization_id', $idCustomization);
                $query->whereNull('parent_id');
            })
            ->get();

        $data = ProductCustomizationOptionId::with([
            'productCustomizationOption',
            'productCustomizationOptionVariationId',
            'productCustomizationOptionVariationId.image',
            'productCustomizationOptionVariationId.productCustomizationOptionVariation'
        ])
        ->find($idOption)
        ->toArray();

        foreach ($data['product_customization_option'] as $key => $val) {
            $data['product_customization_option'][$val['language_code']] = $val;
            unset($data['product_customization_option'][$key]);
        }

        foreach ($data['product_customization_option_variation_id'] as $key => $val) {
            foreach($val['product_customization_option_variation'] as $key2 => $val2){
                $data['product_customization_option_variation_id'][$key]['product_customization_option_variation'][$val2['language_code']] = $val2;
                unset($data['product_customization_option_variation_id'][$key]['product_customization_option_variation'][$key2]);
            }
        }

        return view('backend.pages.products.products.customizations.options.edit', compact('id', 'idCustomization', 'idOption', 'parents', 'data'));
    }

    public function update($id, $idCustomization, $idOption, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [

        ];

        $messages = [];

        $attributes = [

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

        if(empty($data['have_a_child'])){
            foreach($request->variation as $key => $val){
                $rules['variation.'.$key.'.image'] = [];

                $attributes['variation.'.$key.'.image'] = 'Variation Image ' . $key + 1;

                foreach($val['input'] as $lang => $input2){
                    if($lang == 'id'){
                        $rules["variation.". $key . ".input.". $lang.".name"] = ['required'];
                    }else{
                        $rules["variation.". $key . ".input.". $lang.".name"] = [];
                    }

                    $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                    $attributes["variation.". $key . ".input.". $lang.".name"] = "Variation $lang_name Name " . $key + 1;
                }
            }
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

            $optionId = ProductCustomizationOptionId::find($idOption);

            $optionId->fill([
                'id_product_customization_id' => $idCustomization,
                'parent_id' => $data['parent_id'] ?? null,
            ])->save();

            $idOptionId = $optionId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $option = ProductCustomizationOption::where('id_product_customization_option_id', $idOptionId)
                    ->where('language_code', $languageCode)
                    ->first();

                $input['id_product_customization_option_id'] = $idOptionId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                }

                $option->fill($input)->save();

                $idOption = $option->id;
            }

            foreach($data['variation'] as $key => $val){
                if(!empty($val['id'])){
                    $variationId = ProductCustomizationOptionVariationId::find($id);
                }else{
                    $variationId = new ProductCustomizationOptionVariationId();
                }

                $variationId->fill([
                    'id_product_customization_option_id' => $idOptionId
                ])->save();

                $idVariationId = $variationId->id;

                if ($request->hasFile('variation.'.$key.'.image')) {
                    $this->storeFile(
                        $request->file('variation.'.$key.'.image'),
                        $variationId,
                        'image',
                        "images/products/products/customization/option/variation/{$idVariationId}",
                        'image'
                    );
                }

                foreach($val['input'] as $languageCode2 => $val2){
                    if(!empty($val['id'])){
                        $variation = ProductCustomizationOptionVariation::where('id_product_customization_option_variation_id', $val['id'])
                        ->where('language_code', $languageCode2)
                        ->first();
                    }else{
                        $variation = new ProductCustomizationOptionVariation();
                    }

                    $dataVariation['id_product_customization_option_variation_id'] = $idVariationId;
                    $dataVariation['language_code'] = $languageCode2;

                    if($languageCode2 != 'id'){
                        $dataVariation['name'] = $data['variation'][$key]['input']['en']['name'] ?? $data['variation'][$key]['input']['id']['name'];
                    }else{
                        $dataVariation['name'] = $val2['name'];
                    }

                    $variation->fill($dataVariation)->save();
                }
            }

            $message = 'Option created successfully';

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
                'redirect' => url('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization)
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function delete($id, $idCustomization, $idOption)
    {
        try{
            DB::beginTransaction();

            $delete = ProductCustomizationOptionId::where('id', $idOption)->delete();
            $deleteChild = ProductCustomizationOption::where('id_product_customization_option_id', $idOption)->delete();

            DB::commit();

            return redirect('admin-cms/products/products/customizations/'.$id.'/options/'.$idCustomization)->with(['success' => 'Customization has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
