<?php

namespace App\Http\Controllers\Backend\Content\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeMenuSectionId;
use App\Models\HomeMenuSection;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeMenuSectionController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = HomeMenuSection::with([
                'homeMenuSectionId',
                'homeMenuSectionId.image'
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
                    return '<a href="'. $data->homeMenuSectionId->image->path .'" target="_BLANK"><img src="'.$data->homeMenuSectionId->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('is_active', function($data){
                    $id = $data->homeMenuSectionId->id;
                    $isActive = $data->homeMenuSectionId->is_active;

                    return view('backend.pages.content.home.home-menu-section.list.active', compact('id', 'isActive'));
                })
                ->addColumn('url', function($data){
                    return $data->homeMenuSectionId->url;
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/home/home-menu-section/edit/'.$data->homeMenuSectionId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/home/home-menu-section/delete/'.$data->homeMenuSectionId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.home.home-menu-section.index');
    }

    public function create()
    {
        $sort = HomeMenuSectionId::select('sort')->orderBy('sort', 'desc')->first();

        if(!empty($sort)){
            $sort = $sort->sort;
        }

        return view('backend.pages.content.home.home-menu-section.create', compact('sort'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => ['required'],
            'url' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'url' => 'URL',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.cta"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.cta"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.cta"] = "$lang_name Call to Action";
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

            $menuSectionId = new HomeMenuSectionId();

            $sort = empty($data['sort']) ? HomeMenuSectionId::count() + 1 : $data['sort'];

            $menuSectionId->fill([
                'url' => $data['url'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idMenuSectionid = $menuSectionId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $nation = new HomeMenuSection();

                $input['id_home_menu_section_id'] = $idMenuSectionid;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['cta'] = $data['input']['en']['cta'] ?? $data['input']['id']['cta'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $nation->fill($input)->save();

                $idNation = $nation->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $menuSectionId,
                    'image',
                    "images/home/menu-section/image/{$idMenuSectionid}",
                    'image'
                );
            }

            $message = 'Menu Section created successfully';

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
                'redirect' => url('admin-cms/content/home/home-menu-section')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = HomeMenuSectionId::with([
            'image',
            'homeMenuSection'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['home_menu_section'] as $key => $val) {
            $data['home_menu_section'][$val['language_code']] = $val;
            unset($data['home_menu_section'][$key]);
        }

        $sort = HomeMenuSectionId::select('sort')->orderBy('sort', 'desc')->first();
        $sort = $sort->sort;

        return view('backend.pages.content.home.home-menu-section.edit', compact('data', 'sort'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => [],
            'url' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'url' => 'URL',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.cta"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.cta"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.cta"] = "$lang_name Call to Action";
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

            $menuSectionId = HomeMenuSectionId::find($id);

            $sort = empty($data['sort']) ? HomeMenuSectionId::count() + 1 : $data['sort'];

            $menuSectionId->fill([
                'url' => $data['url'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idMenuSectionid = $menuSectionId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $nation = HomeMenuSection::where('language_code', $languageCode)->where('id_home_menu_section_id', $id)->first();

                $input['id_home_menu_section_id'] = $idMenuSectionid;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['cta'] = $data['input']['en']['cta'] ?? $data['input']['id']['cta'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $nation->fill($input)->save();

                $idNation = $nation->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $menuSectionId,
                    'image',
                    "images/home/menu-section/image/{$idMenuSectionid}",
                    'image'
                );
            }

            $message = 'Menu Section updated successfully';

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
                'redirect' => url('admin-cms/content/home/home-menu-section')
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

                $update = HomeMenuSectionId::where('id', $id)->update([
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

            $delete = HomeMenuSectionId::where('id', $id)->delete();
            $deleteChild = HomeMenuSection::where('id_home_menu_section_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/home/home-menu-section')->with(['success' => 'Menu Section has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
