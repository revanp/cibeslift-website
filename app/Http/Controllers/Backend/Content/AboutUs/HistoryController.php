<?php

namespace App\Http\Controllers\Backend\Content\AboutUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HistoryId;
use App\Models\History;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = History::with([
                'historyId',
                'historyId.image'
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
                    return '<a href="'. $data->historyId->image->path .'" target="_BLANK"><img src="'.$data->historyId->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('sort', function($data){
                    return $data->historyId->sort;
                })
                ->addColumn('year', function($data){
                    return $data->historyId->year;
                })
                ->addColumn('is_active', function($data){
                    $id = $data->historyId->id;
                    $isActive = $data->historyId->is_active;

                    return view('backend.layouts.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/about-us/history/edit/'.$data->historyId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/about-us/history/delete/'.$data->historyId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.about-us.history.index');
    }

    public function create()
    {
        $sort = HistoryId::select('sort')->orderBy('sort', 'desc')->first();
        if(!empty($sort)){
            $sort = $sort->sort;
        }

        return view('backend.pages.content.about-us.history.create', compact('sort'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => ['required'],
            'year' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'year' => 'Year',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

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

            $historyId = new HistoryId();

            $sort = empty($data['sort']) ? HistoryId::count() + 1 : $data['sort'];

            $historyId->fill([
                'year' => $data['year'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idHistoryId = $historyId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $history = new History();

                $input['id_history_id'] = $idHistoryId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $history->fill($input)->save();

                $idHistory = $history->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $historyId,
                    'image',
                    "images/about-us/history/image/{$idHistoryId}",
                    'image'
                );
            }

            $message = 'History created successfully';

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
                'redirect' => url('admin-cms/content/about-us/history')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = HistoryId::with([
            'image',
            'history'
        ])
        ->find($id)
        ->toArray();

        foreach ($data['history'] as $key => $val) {
            $data['history'][$val['language_code']] = $val;
            unset($data['history'][$key]);
        }

        $sort = HistoryId::select('sort')->orderBy('sort', 'desc')->first();
        $sort = $sort->sort;

        return view('backend.pages.content.about-us.history.edit', compact('data', 'sort'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => [],
            'year' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'year' => 'Year',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

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

            $historyId = HistoryId::find($id);

            $sort = empty($data['sort']) ? HistoryId::count() + 1 : $data['sort'];

            $historyId->fill([
                'year' => $data['year'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idHistoryId = $historyId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $history = History::where('id_history_id', $id)->where('language_code', $languageCode)->first();

                $input['id_history_id'] = $idHistoryId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $history->fill($input)->save();

                $idHistory = $history->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $historyId,
                    'image',
                    "images/about-us/history/image/{$idHistoryId}",
                    'image'
                );
            }

            $message = 'History created successfully';

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
                'redirect' => url('admin-cms/content/about-us/history')
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

                $update = HistoryId::where('id', $id)->update([
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

            $delete = HistoryId::where('id', $id)->delete();
            $deleteChild = History::where('id_history_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/about-us/history')->with(['success' => 'History has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            dd($e->getMessage());

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
