<?php

namespace App\Http\Controllers\Backend\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeaderBannerId;
use App\Models\HeaderBanner;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class HeaderBannerController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = HeaderBanner::with([
                'headerBannerId',
                'headerBannerId.image'
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
                    return '<a href="'. $data->headerBannerId->image->path .'" target="_BLANK"><img src="'.$data->headerBannerId->image->path.'" style="width:200px;"></a>';
                })
                ->addColumn('is_active', function($data){
                    $id = $data->headerBannerId->id;
                    $isActive = $data->headerBannerId->is_active;

                    return view('backend.pages.content.header-banner.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/header-banner/edit/'.$data->headerBannerId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/header-banner/delete/'.$data->headerBannerId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.header-banner.index');
    }

    public function create()
    {
        return view('backend.pages.content.header-banner.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'image' => ['required', 'file', 'image'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Upload File',
        ];

        foreach ($request->input as $lang => $input) {
            $rules["input.$lang.title"] = ['required'];
            $rules["input.$lang.description"] = ['required'];
            $rules["input.$lang.cta"] = ['required'];
            $rules["input.$lang.link"] = ['required'];

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.cta"] = "$lang_name Call To Action";
            $attributes["input.$lang.link"] = "$lang_name Link";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $headerBannerId = new HeaderBannerId();

            $headerBannerId->fill([
                'is_active' => true
            ])->save();

            $idHeaderBannerId = $headerBannerId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $headerBanner = new HeaderBanner();

                $input['id_header_banner_id'] = $idHeaderBannerId;
                $input['language_code'] = $languageCode;
                $input['created_by'] = $user->id;
                $input['updated_by'] = $user->id;
                $input['deleted_by'] = 0;

                $headerBanner->fill($input)->save();

                $idHeaderBanner = $headerBanner->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $headerBannerId,
                    'image',
                    "images/header-banner/{$idHeaderBannerId}",
                    'image'
                );
            }

            $message = 'Header Banner created successfully';

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
            return redirect(url('admin-cms/content/header-banner'))
                ->with(['success' => $message]);
        }
    }

    public function edit($id)
    {
        $headerBannerId = HeaderBannerId::find($id);

        $imagePath = (!empty($headerBannerId) && $headerBannerId->image) ? $headerBannerId->image->path : '';

        $headerBanner = HeaderBanner::where('id_header_banner_id', $id)
            ->get()
            ->toArray();

        foreach ($headerBanner as $key => $val) {
            $headerBanner[$val['language_code']] = $val;
            unset($headerBanner[$key]);
        }

        return view('backend.pages.content.header-banner.edit', compact('headerBannerId', 'imagePath', 'headerBanner'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'image' => ['file', 'image'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Upload File',
        ];

        foreach ($request->input as $lang => $input) {
            $rules["input.$lang.title"] = ['required'];
            $rules["input.$lang.description"] = ['required'];
            $rules["input.$lang.cta"] = ['required'];
            $rules["input.$lang.link"] = ['required'];

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.cta"] = "$lang_name Call To Action";
            $attributes["input.$lang.link"] = "$lang_name Link";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $headerBannerId = HeaderBannerId::find($id);

            $headerBannerId->fill([
                'is_active' => true
            ])->save();

            $idHeaderBannerId = $headerBannerId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $headerBanner = HeaderBanner::where([
                    'id_header_banner_id' => $id,
                    'language_code' => $languageCode
                ])->first();

                $input['id_header_banner_id'] = $idHeaderBannerId;
                $input['language_code'] = $languageCode;
                $input['created_by'] = $user->id;
                $input['updated_by'] = $user->id;
                $input['deleted_by'] = 0;

                $headerBanner->fill($input)->save();

                $idHeaderBanner = $headerBanner->id;
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $headerBannerId,
                    'image',
                    "images/header-banner/{$idHeaderBannerId}",
                    'image'
                );
            }

            $message = 'Header Banner updated successfully';

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
            return redirect(url('admin-cms/content/header-banner'))
                ->with(['success' => $message]);
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

                $update = HeaderBannerId::where('id', $id)->update([
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

            $delete = HeaderBannerId::where('id', $id)->delete();

            $deleteChild = HeaderBanner::where('id_header_banner_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/header-banner')->with(['success' => 'Header Banner has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
