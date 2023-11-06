<?php

namespace App\Http\Controllers\Backend\Products\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductFaq;
use App\Models\ProductFaqId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    public function index($id, Request $request)
    {
        $datas = ProductFaq::with(['productFaqId'])
            ->where('language_code', 'id')
            ->get();

        return view('backend.pages.products.products.faq.index', compact('id', 'datas'));
    }

    public function create($id)
    {
        return view('backend.pages.products.products.faq.create', compact('id'));
    }

    public function store($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [

        ];

        $messages = [];

        $attributes = [

        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.description"] = "$lang_name Description";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $faqId = new ProductFaqId();

            $faqId->fill([
                'id_product_id' => $id,
                'is_active' => true
            ])->save();

            $idFaqId = $faqId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $faq = new ProductFaq();

                $input['id_product_faq_id'] = $idFaqId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $faq->fill($input)->save();

                $idFaq = $faq->id;
            }

            $message = 'Faq created successfully';

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
            return redirect(url('admin-cms/products/products/faq/'.$id))
                ->with(['success' => $message]);
        }
    }

    public function edit($id, $idFaq)
    {
        $data = ProductFaqId::with([
            'productFaq'
        ])
        ->find($idFaq)
        ->toArray();

        foreach ($data['product_faq'] as $key => $val) {
            $data['product_faq'][$val['language_code']] = $val;
            unset($data['product_faq'][$key]);
        }

        return view('backend.pages.products.products.faq.edit', compact('data', 'id'));
    }

    public function update($id, $idFaq, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [

        ];

        $messages = [];

        $attributes = [

        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.description"] = "$lang_name Description";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $faqId = ProductFaqId::find($idFaq);

            $faqId->fill([
                'id_product_id' => $id,
                'is_active' => !true
            ])->save();

            $idFaqId = $faqId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $faq = ProductFaq::where('language_code', $languageCode)->where('id_product_faq_id', $idFaq)->first();

                $input['id_product_faq_id'] = $idFaqId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $faq->fill($input)->save();

                $idFaq = $faq->id;
            }

            $message = 'Faq updated successfully';

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
            return redirect(url('admin-cms/products/products/faq/'.$id))
                ->with(['success' => $message]);
        }
    }

    public function delete($id, $idFaq)
    {
        try{
            DB::beginTransaction();

            $delete = ProductFaqId::where('id', $idFaq)->delete();

            $deleteChild = ProductFaq::where('id_product_faq_id', $idFaq)->delete();

            DB::commit();

            return redirect('admin-cms/products/products/faq/'.$id)->with(['success' => 'Faq has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
