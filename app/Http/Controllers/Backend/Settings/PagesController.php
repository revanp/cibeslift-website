<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageId;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $pages = Page::with(['pageId'])->where('language_code', 'id');

            if ($reqDatatable['orderable']) {
                foreach ($reqDatatable['orderable'] as $order) {
                    if($order['column'] == 'rownum') {
                        $pages = $pages->orderBy('id', $order['dir']);
                    } else {
                        if(!empty($val['column'])){
                            $pages = $pages->orderBy($order['column'], $order['dir']);
                        }else{
                            $pages = $pages->orderBy('id', 'desc');
                        }
                    }
                }
            } else {
                $pages = $pages->orderBy('id', 'desc');
            }

            $datatables = DataTables::of($pages);

            if (isset($reqDatatable['orderable']['rownum'])) {
                if ($reqDatatable['orderable']['rownum']['dir'] == 'desc') {
                    $rownum      = abs($pages->count() - ($reqDatatable['start'] * $reqDatatable['length']));
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
                ->addColumn('slug', function($data){
                    return $data->pageId->slug;
                })
                ->editColumn('created_at', function($data){
                    return date('d F Y H:i:s', strtotime($data->created_at));
                })
                ->editColumn('updated_at', function($data){
                    return date('d F Y H:i:s', strtotime($data->updated_at));
                })
                ->addColumn('action', function($data){
                    if(Auth::user()->id == $data->id){
                        return '';
                    }else{
                        $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                            //* EDIT
                            $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/settings/pages/edit/'.$data->pageId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';
                        $html .= '</ul></div></div>';

                        return $html;
                    }
                })
                ->rawColumns(['action'])
                ->toJson(true);
        }

        return view('backend.pages.settings.pages.index');
    }

    public function edit($id)
    {
        $pageId = PageId::find($id);

        $page = Page::where('id_page_id', $id)
            ->get()
            ->toArray();

        foreach ($page as $key => $val) {
            $page[$val['language_code']] = $val;
            unset($page[$key]);
        }

        return view('backend.pages.settings.pages.edit', compact('pageId', 'page'));
    }

    public function update($id, Request $request)
    {
        $data = $request->post();

        unset($data['_token']);

        $rules = [

        ];

        $messages = [];

        $attributes = [

        ];

        foreach ($request->input as $lang => $input) {
            $rules["input.$lang.name"] = ['required'];

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $pageId = PageId::find($id);

            foreach ($data['input'] as $languageCode => $input) {
                $page = Page::where([
                    'id_page_id' => $id,
                    'language_code' => $languageCode
                ])->first();

                $page->fill($input)->save();
            }

            $message = 'Page updated successfully';

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
            return redirect(url('admin-cms/settings/pages'))
                ->with(['success' => $message]);
        }
    }
}
