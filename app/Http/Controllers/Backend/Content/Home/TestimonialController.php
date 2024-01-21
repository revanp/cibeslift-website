<?php

namespace App\Http\Controllers\Backend\Content\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TestimonialId;
use App\Models\Testimonial;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = Testimonial::with([
                'testimonialId',
                'testimonialId.image',
                'testimonialId.productId',
                'testimonialId.productId.product' => function($query){
                    $query->where('language_code', '=', 'id');
                }
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
                    return '<a href="'. $data->testimonialId->image->path .'" target="_BLANK"><img src="'.$data->testimonialId->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('is_active', function($data){
                    $id = $data->testimonialId->id;
                    $isActive = $data->testimonialId->is_active;

                    return view('backend.pages.content.home.testimonial.list.active', compact('id', 'isActive'));
                })
                ->addColumn('product', function($data){
                    return $data->testimonialId->productId->product[0]->name;
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/home/testimonial/edit/'.$data->testimonialId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/home/testimonial/delete/'.$data->testimonialId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.home.testimonial.index');
    }

    public function create()
    {
        $products = Product::with([
            'productId'
        ])
        ->whereHas('productId', function($query){
            $query->where('have_a_child', false);
        })
        ->where('language_code', 'id')
        ->get();

        $sort = TestimonialId::select('sort')->orderBy('sort', 'desc')->first();

        if(!empty($sort)){
            $sort = $sort->sort;
        }

        return view('backend.pages.content.home.testimonial.create', compact('products', 'sort'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => ['required'],
            'id_product_id' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'id_product_id' => 'Product',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.customer"] = ['required'];
                $rules["input.$lang.testimony"] = ['required'];
            }else{
                $rules["input.$lang.customer"] = [];
                $rules["input.$lang.testimony"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.customer"] = "$lang_name Customer";
            $attributes["input.$lang.testimony"] = "$lang_name Testimony";
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

            $menuSectionId = new TestimonialId();

            $sort = empty($data['sort']) ? TestimonialId::count() + 1 : $data['sort'];

            $menuSectionId->fill([
                'id_product_id' => $data['id_product_id'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idMenuSectionid = $menuSectionId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $nation = new Testimonial();

                $input['id_testimonial_id'] = $idMenuSectionid;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['customer'] = $data['input']['en']['customer'] ?? $data['input']['id']['customer'];
                    $input['testimony'] = $data['input']['en']['testimony'] ?? $data['input']['id']['testimony'];
                }

                $nation->fill($input)->save();

                $idNation = $nation->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $menuSectionId,
                    'image',
                    "images/home/testimonial/image/{$idMenuSectionid}",
                    'image'
                );
            }

            $message = 'Testimonial created successfully';

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
                'redirect' => url('admin-cms/content/home/testimonial')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = TestimonialId::with([
            'image',
            'testimonial'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['testimonial'] as $key => $val) {
            $data['testimonial'][$val['language_code']] = $val;
            unset($data['testimonial'][$key]);
        }

        $products = Product::with([
            'productId'
        ])
        ->whereHas('productId', function($query){
            $query->where('have_a_child', false);
        })
        ->where('language_code', 'id')
        ->get();

        $sort = TestimonialId::select('sort')->orderBy('sort', 'desc')->first();
        $sort = $sort->sort;

        return view('backend.pages.content.home.testimonial.edit', compact('products', 'data', 'sort'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => [],
            'id_product_id' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'id_product_id' => 'Product',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.customer"] = ['required'];
                $rules["input.$lang.testimony"] = ['required'];
            }else{
                $rules["input.$lang.customer"] = [];
                $rules["input.$lang.testimony"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.customer"] = "$lang_name Customer";
            $attributes["input.$lang.testimony"] = "$lang_name Testimony";
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

            $menuSectionId = TestimonialId::find($id);

            $sort = empty($data['sort']) ? TestimonialId::count() + 1 : $data['sort'];

            $menuSectionId->fill([
                'id_product_id' => $data['id_product_id'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idMenuSectionid = $menuSectionId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $nation = Testimonial::where('id_testimonial_id', $id)->where('language_code', $languageCode)->first();

                $input['id_testimonial_id'] = $idMenuSectionid;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['customer'] = $data['input']['en']['customer'] ?? $data['input']['id']['customer'];
                    $input['testimony'] = $data['input']['en']['testimony'] ?? $data['input']['id']['testimony'];
                }

                $nation->fill($input)->save();

                $idNation = $nation->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $menuSectionId,
                    'image',
                    "images/home/testimonial/image/{$idMenuSectionid}",
                    'image'
                );
            }

            $message = 'Testimonial updated successfully';

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
                'redirect' => url('admin-cms/content/home/testimonial')
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

                $update = TestimonialId::where('id', $id)->update([
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

            $delete = TestimonialId::where('id', $id)->delete();
            $deleteChild = Testimonial::where('id_testimonial_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/home/testimonial')->with(['success' => 'Testimonial has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
