<?php

namespace App\Http\Controllers\Backend\Content\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhyCibesTitle;
use App\Models\WhyCibesUsp;
use App\Models\WhyCibesUspId;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WhyCibesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = WhyCibesUsp::with([
                'whyCibesUspId',
                'whyCibesUspId.image'
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
                    return '<a href="'. $data->whyCibesUspId->image->path .'" target="_BLANK"><img src="'.$data->whyCibesUspId->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('is_active', function($data){
                    $id = $data->whyCibesUspId->id;
                    $isActive = $data->whyCibesUspId->is_active;

                    return view('backend.pages.content.home.why-cibes.list.active', compact('id', 'isActive'));
                })
                ->addColumn('url', function($data){
                    return $data->whyCibesUspId->url;
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/home/why-cibes/edit/'.$data->whyCibesUspId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/home/why-cibes/delete/'.$data->whyCibesUspId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        $title = WhyCibesTitle::with(['image'])->get()->toArray();

        foreach ($title as $key => $val) {
            $title[$val['language_code']] = $val;
            unset($title[$key]);
        }

        return view('backend.pages.content.home.why-cibes.index', compact('title'));
    }

    public function storeTitle(Request $request)
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
                $title = WhyCibesTitle::where('language_code', $languageCode)->first();

                if(empty($title)){
                    $title = new WhyCibesTitle();
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
                        "images/home/why-cibes/title/image/{$idTitle}",
                        'image'
                    );
                }
            }

            $message = 'Why Cibes Title created/updated successfully';

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
                'redirect' => url('admin-cms/content/home/why-cibes')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function create()
    {
        $sort = WhyCibesUspId::select('sort')->orderBy('sort', 'desc')->first();

        if(!empty($sort)){
            $sort = $sort->sort;
        }

        return view('backend.pages.content.home.why-cibes.create', compact('sort'));
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
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.subtitle"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.subtitle"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.subtitle"] = "$lang_name Subtitle";
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

            $uspId = new WhyCibesUspId();

            $sort = empty($data['sort']) ? WhyCibesUspId::count() + 1 : $data['sort'];

            $uspId->fill([
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idUspId = $uspId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $usp = new WhyCibesUsp();

                $input['id_why_cibes_usp_id'] = $idUspId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['subtitle'] = $data['input']['en']['subtitle'] ?? $data['input']['id']['subtitle'];
                }

                $usp->fill($input)->save();

                $idUsp = $usp->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $uspId,
                    'image',
                    "images/home/why-cibes/usp/image/{$idUspId}",
                    'image'
                );
            }

            $message = 'Why Cibes USP created successfully';

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
                'redirect' => url('admin-cms/content/home/why-cibes')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = WhyCibesUspId::with([
            'image',
            'whyCibesUsp'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['why_cibes_usp'] as $key => $val) {
            $data['why_cibes_usp'][$val['language_code']] = $val;
            unset($data['why_cibes_usp'][$key]);
        }

        $sort = WhyCibesUspId::select('sort')->orderBy('sort', 'desc')->first();
        $sort = $sort->sort;

        return view('backend.pages.content.home.why-cibes.edit', compact('data', 'sort'));
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
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.subtitle"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.subtitle"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.subtitle"] = "$lang_name Subtitle";
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

            $uspId = WhyCibesUspId::find($id);

            $sort = empty($data['sort']) ? WhyCibesUspId::count() + 1 : $data['sort'];

            $uspId->fill([
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idUspId = $uspId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $usp = WhyCibesUsp::where('language_code', $languageCode)->where('id_why_cibes_usp_id', $id)->first();

                $input['id_why_cibes_usp_id'] = $idUspId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['subtitle'] = $data['input']['en']['subtitle'] ?? $data['input']['id']['subtitle'];
                }

                $usp->fill($input)->save();

                $idUsp = $usp->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $uspId,
                    'image',
                    "images/home/why-cibes/usp/image/{$idUspId}",
                    'image'
                );
            }

            $message = 'Why Cibes USP updated successfully';

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
                'redirect' => url('admin-cms/content/home/why-cibes')
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

                $update = WhyCibesUspId::where('id', $id)->update([
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

            $delete = WhyCibesUspId::where('id', $id)->delete();
            $deleteChild = WhyCibesUsp::where('id_why_cibes_usp_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/home/why-cibes')->with(['success' => 'Menu Section has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
