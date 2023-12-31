<?php

namespace App\Http\Controllers\Backend\Content\AboutUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Showroom;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShowroomController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = Showroom::with([
                'image',
            ]);

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
                    return '<a href="'. $data->image->path .'" target="_BLANK"><img src="'.$data->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('sort', function($data){
                    return $data->sort;
                })
                ->addColumn('is_active', function($data){
                    $id = $data->id;
                    $isActive = $data->is_active;

                    return view('backend.layouts.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/about-us/showroom/edit/'.$data->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/about-us/showroom/delete/'.$data->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.about-us.showroom.index');
    }

    public function create()
    {
        $sort = Showroom::select('sort')->orderBy('sort', 'desc')->first();

        if(!empty($sort)){
            $sort = $sort->sort;
        }

        return view('backend.pages.content.about-us.showroom.create', compact('sort'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => ['required'],
            'name' => ['required'],
            'address' => ['required'],
            'google_maps_link' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'name' => 'Name',
            'address' => 'Address',
            'google_maps_link' => 'Google Maps Link',
        ];

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

            $showroom = new Showroom();

            $sort = empty($data['sort']) ? Showroom::count() + 1 : $data['sort'];

            $showroom->fill([
                'name' => $data['name'],
                'address' => $data['address'],
                'google_maps_link' => $data['google_maps_link'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idShowroom = $showroom->id;

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $showroom,
                    'image',
                    "images/about-us/showroom/image/{$idShowroom}",
                    'image'
                );
            }

            $message = 'Showroom created successfully';

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
                'redirect' => url('admin-cms/content/about-us/showroom')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $data = Showroom::with([
            'image',
        ])
        ->find($id)
        ->toArray();

        $sort = Showroom::select('sort')->orderBy('sort', 'desc')->first();
        $sort = $sort->sort;

        return view('backend.pages.content.about-us.showroom.edit', compact('data', 'sort'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => [],
            'name' => ['required'],
            'address' => ['required'],
            'google_maps_link' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'name' => 'Name',
            'address' => 'Address',
            'google_maps_link' => 'Google Maps Link',
        ];

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

            $showroom = Showroom::find($id);

            $sort = empty($data['sort']) ? Showroom::count() + 1 : $data['sort'];

            $showroom->fill([
                'name' => $data['name'],
                'address' => $data['address'],
                'google_maps_link' => $data['google_maps_link'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'sort' => $sort,
            ])->save();

            $idShowroom = $showroom->id;

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $showroom,
                    'image',
                    "images/about-us/showroom/image/{$idShowroom}",
                    'image'
                );
            }

            $message = 'Showroom updated successfully';

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
                'redirect' => url('admin-cms/content/about-us/showroom')
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

                $update = Showroom::where('id', $id)->update([
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

            $delete = Showroom::where('id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/about-us/showroom')->with(['success' => 'Showroom has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
