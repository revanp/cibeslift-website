<?php

namespace App\Http\Controllers\Backend\Content\Faq;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqCategoryId;
use App\Models\FaqCategory;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = FaqCategory::with([
                'faqCategoryId',
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
                ->addColumn('is_active', function($data){
                    $id = $data->faqCategoryId->id;
                    $isActive = $data->faqCategoryId->is_active;

                    return view('backend.pages.content.faq.categories.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/faq/categories/edit/'.$data->faqCategoryId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/faq/categories/delete/'.$data->faqCategoryId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.faq.categories.index');
    }

    public function create()
    {
        return view('backend.pages.content.faq.categories.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [];

        $messages = [];

        $attributes = [];

        foreach ($request->input as $lang => $input) {
            $rules["input.$lang.name"] = ['required'];

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $faqCategoryId = new FaqCategoryId();

            $faqCategoryId->fill([
                'is_active' => true
            ])->save();

            $idFaqCategoryId = $faqCategoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $faqCategory = new FaqCategory();

                $input['id_faq_category_id'] = $idFaqCategoryId;
                $input['language_code'] = $languageCode;
                $input['created_by'] = $user->id;
                $input['updated_by'] = $user->id;
                $input['deleted_by'] = 0;

                $faqCategory->fill($input)->save();

                $idFaqCategory = $faqCategory->id;
            }

            $message = 'Faq Category created successfully';

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
            return redirect(url('admin-cms/content/faq/categories'))
                ->with(['success' => $message]);
        }
    }

    public function edit($id)
    {
        $faqCategoryId = FaqCategoryId::find($id);

        $faqCategory = FaqCategory::where('id_faq_category_id', $id)
            ->get()
            ->toArray();

        foreach ($faqCategory as $key => $val) {
            $faqCategory[$val['language_code']] = $val;
            unset($faqCategory[$key]);
        }

        return view('backend.pages.content.faq.categories.edit', compact('faqCategoryId', 'faqCategory'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [];

        $messages = [];

        $attributes = [];

        foreach ($request->input as $lang => $input) {
            $rules["input.$lang.name"] = ['required'];

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $faqCategoryId = FaqCategoryId::find($id);

            $faqCategoryId->fill([
                'is_active' => true
            ])->save();

            $idFaqCategoryId = $faqCategoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $faqCategory = FaqCategory::where('id_faq_category_id', $id)->first();

                $input['id_faq_category_id'] = $idFaqCategoryId;
                $input['language_code'] = $languageCode;
                $input['created_by'] = $user->id;
                $input['updated_by'] = $user->id;
                $input['deleted_by'] = 0;

                $faqCategory->fill($input)->save();

                $idFaqCategory = $faqCategory->id;
            }

            $message = 'Faq Category updated successfully';

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
            return redirect(url('admin-cms/content/faq/categories'))
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

                $update = FaqCategoryId::where('id', $id)->update([
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

            $delete = FaqCategoryId::where('id', $id)->delete();

            $deleteChild = FaqCategory::where('id_faq_category_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/faq/categories')->with(['success' => 'Faq Category has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
