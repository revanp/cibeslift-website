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
                $query->where('level', 1);
                $query->where('id_product_customization_id', $idCustomization);
                $query->where('have_a_child', true);
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
                'level' => !empty($data['parent_id']) ? 2 : 1,
                'parent_id' => $data['parent_id'] ?? null,
                'have_a_child' => !empty($data['have_a_child']) ? true : false
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

            // foreach($data['usp'] as $key => $val){
            //     $uspId = new ProductCustomizationOptionVariationId();

            //     $uspId->fill([
            //         'id_product_id' => $idProductId
            //     ])->save();

            //     $idUspId = $uspId->id;

            //     if ($request->hasFile('usp.'.$key.'.image')) {
            //         $this->storeFile(
            //             $request->file('usp.'.$key.'.image'),
            //             $uspId,
            //             'image',
            //             "images/products/products/usp/{$idUspId}",
            //             'image'
            //         );
            //     }

            //     foreach($val['input'] as $languageCode2 => $val2){
            //         $usp = new ProductUsp();

            //         $dataUsp['id_product_usp_id'] = $idUspId;
            //         $dataUsp['language_code'] = $languageCode2;

            //         if($languageCode2 != 'id'){
            //             $dataUsp['name'] = $data['usp'][$key]['input']['en']['name'] ?? $data['usp'][$key]['input']['id']['name'];
            //             $dataUsp['description'] = $data['usp'][$key]['input']['en']['description'] ?? $data['usp'][$key]['input']['id']['description'];
            //         }else{
            //             $dataUsp['name'] = $val2['name'];
            //             $dataUsp['description'] = $val2['description'];
            //         }

            //         $usp->fill($dataUsp)->save();
            //     }
            // }

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
}
