<?php

namespace App\Http\Controllers\Backend\Content\AboutUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUsAftersalesId;
use App\Models\AboutUsAftersales;
use App\Models\AboutUsAftersalesTitle;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AftersalesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = AboutUsAftersales::with([
                'aboutUsAftersalesId',
                'aboutUsAftersalesId.image'
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
                    return '<a href="'. $data->aboutUsAftersalesId->image->path .'" target="_BLANK"><img src="'.$data->aboutUsAftersalesId->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('is_active', function($data){
                    $id = $data->aboutUsAftersalesId->id;
                    $isActive = $data->aboutUsAftersalesId->is_active;

                    return view('backend.pages.content.home.why-cibes.list.active', compact('id', 'isActive'));
                })
                ->addColumn('url', function($data){
                    return $data->aboutUsAftersalesId->url;
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/about-us/aftersales/edit/'.$data->aboutUsAftersalesId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/about-us/aftersales/delete/'.$data->aboutUsAftersalesId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        $title = AboutUsAftersalesTitle::with(['image'])->get()->toArray();

        foreach ($title as $key => $val) {
            $title[$val['language_code']] = $val;
            unset($title[$key]);
        }

        return view('backend.pages.content.about-us.aftersales.index', compact('title'));
    }

    public function storeTitle(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $check = AboutUsAftersalesTitle::first();

        if(!empty($check)){
            $rules = [
                'image' => [],
            ];
        }else{
            $rules = [
                'image' => ['required'],
            ];
        }

        $messages = [];

        $attributes = [
            'image' => 'Image',
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

            foreach ($data['input'] as $languageCode => $input) {
                $title = AboutUsAftersalesTitle::where('language_code', $languageCode)->first();

                if(empty($title)){
                    $title = new AboutUsAftersalesTitle();
                }

                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $title->fill($input)->save();

                $idTitle = $title->id;

                if ($request->hasFile('image')) {
                    $this->storeFile(
                        $request->file('image'),
                        $title,
                        'image',
                        "images/about-us/aftersales/title/image/{$idTitle}",
                        'image'
                    );
                }
            }

            $message = 'Aftersales Title created/updated successfully';

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
                'redirect' => url('admin-cms/content/about-us/aftersales')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function create()
    {
        $sort = AboutUsAftersalesId::select('sort')->orderBy('sort', 'desc')->first();
        if(!empty($sort)){
            $sort = $sort->sort;
        }

        return view('backend.pages.content.about-us.aftersales.create', compact('sort'));
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
                $rules["input.$lang.description"] = [];
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

            $aftersalesId = new AboutUsAftersalesId();

            $sort = empty($data['sort']) ? AboutUsAftersalesId::count() + 1 : $data['sort'];

            $aftersalesId->fill([
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idAftersalesId = $aftersalesId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $aftersales = new AboutUsAftersales();

                $input['id_about_us_aftersales_id'] = $idAftersalesId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $aftersales->fill($input)->save();
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $aftersalesId,
                    'image',
                    "images/about-us/aftersales/image/{$idAftersalesId}",
                    'image'
                );
            }

            $message = 'Aftersales created successfully';

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
                'redirect' => url('admin-cms/content/about-us/aftersales')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = AboutUsAftersalesId::with([
            'image',
            'aboutUsAftersales'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['about_us_aftersales'] as $key => $val) {
            $data['about_us_aftersales'][$val['language_code']] = $val;
            unset($data['about_us_aftersales'][$key]);
        }

        $sort = AboutUsAftersalesId::select('sort')->orderBy('sort', 'desc')->first();
        $sort = $sort->sort;

        return view('backend.pages.content.about-us.aftersales.edit', compact('data', 'sort'));
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
                $rules["input.$lang.description"] = [];
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

            $aftersalesId = AboutUsAftersalesId::find($id);

            $sort = empty($data['sort']) ? AboutUsAftersalesId::count() + 1 : $data['sort'];

            $aftersalesId->fill([
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idAftersalesId = $aftersalesId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $aftersales = AboutUsAftersales::where('id_about_us_aftersales_id', $id)->where('language_code', $languageCode)->first();

                $input['id_about_us_aftersales_id'] = $idAftersalesId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['name'] = $data['input']['en']['name'] ?? $data['input']['id']['name'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $aftersales->fill($input)->save();
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $aftersalesId,
                    'image',
                    "images/about-us/aftersales/image/{$idAftersalesId}",
                    'image'
                );
            }

            $message = 'Aftersales updated successfully';

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
                'redirect' => url('admin-cms/content/about-us/aftersales')
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

                $update = AboutUsAftersalesId::where('id', $id)->update([
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

            $delete = AboutUsAftersalesId::where('id', $id)->delete();
            $deleteChild = AboutUsAftersales::where('id_about_us_highlight_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/about-us/aftersales')->with(['success' => 'Aftersales has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
