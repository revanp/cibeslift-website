<?php

namespace App\Http\Controllers\Backend\Content\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategoryId;
use App\Models\NewsCategory;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = NewsCategory::with([
                'newsCategoryId',
            ])->where('language_code', 'id');

            if ($reqDatatable['orderable']) {
                foreach ($reqDatatable['orderable'] as $order) {
                    if ($order['column'] == 'rownum') {
                        $data = $data->orderBy('id', $order['dir']);
                    } else {
                        if (!empty($val['column'])) {
                            $data = $data->orderBy($order['column'], $order['dir']);
                        } else {
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
                ->addColumn('rownum', function () use (&$rownum, $is_increase) {
                    if ($is_increase == true) {
                        return $rownum++;
                    } else {
                        return $rownum--;
                    }
                })
                ->addColumn('is_active', function ($data) {
                    $id = $data->newsCategoryId->id;
                    $isActive = $data->newsCategoryId->is_active;

                    return view('backend.pages.content.news.categories.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function ($data) {
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                    //* EDIT
                    $html .= '<li class="nav-item"><a class="nav-link" href="' . url('admin-cms/content/news/categories/edit/' . $data->newsCategoryId->id) . '"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                    //* DELETE
                    $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="' . url('admin-cms/content/news/categories/delete/' . $data->newsCategoryId->id) . '"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.news.categories.index');
    }

    public function create()
    {
        return view('backend.pages.content.news.categories.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [];

        $messages = [];

        $attributes = [];

        foreach ($request->input as $lang => $input) {
            $rules["input.$lang.name"] = ['required'];

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
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

        try {
            DB::beginTransaction();

            $newsCategoryId = new NewsCategoryId();
            $newsCategoryId->fill([
                'is_active' => true,
                'sort' => 0,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idNewsCategoryId = $newsCategoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $newsCategory = new NewsCategory();

                $input['id_news_category_id'] = $idNewsCategoryId;
                $input['slug'] = Str::slug($input['name']);
                $input['language_code'] = $languageCode;

                $newsCategory->fill($input)->save();

                $idNewsCategory = $newsCategory->id;
            }

            $message = 'News Category created successfully';

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
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
                'redirect' => url('admin-cms/content/news/categories')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }

    public function edit($id)
    {
        $newsCategoryId = NewsCategoryId::find($id);

        $newsCategory = NewsCategory::where('id_news_category_id', $id)
            ->get()
            ->toArray();

        foreach ($newsCategory as $key => $val) {
            $newsCategory[$val['language_code']] = $val;
            unset($newsCategory[$key]);
        }

        return view('backend.pages.content.news.categories.edit', compact('newsCategoryId', 'newsCategory'));
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

        try {
            DB::beginTransaction();

            $newsCategoryId = NewsCategoryId::find($id);

            $newsCategoryId->fill([
                'is_active' => true,
                'sort' => 0,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idNewsCategoryId = $newsCategoryId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $newsCategory = NewsCategory::where('language_code', $languageCode)->where('id_news_category_id', $id)->first();

                $input['id_news_category_id'] = $idNewsCategoryId;
                $input['language_code'] = $languageCode;

                $newsCategory->fill($input)->save();

                $idNewsCategory = $newsCategory->id;
            }

            $message = 'News Category updated successfully';

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
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
                'redirect' => url('admin-cms/content/news/categories')
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

        if ($isAjax) {
            $id = $input['id'];
            $isError = true;

            $status = $input['status'] == '0' ? false : true;

            try {
                DB::beginTransaction();

                $update = NewsCategoryId::where('id', $id)->update([
                    'is_active' => $status
                ]);

                DB::commit();

                return response([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Status has been changed successfully'
                ]);
            } catch (Exception $e) {
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
        try {
            DB::beginTransaction();

            $delete = NewsCategoryId::where('id', $id)->delete();

            $deleteChild = NewsCategory::where('id_news_category_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/content/news/categories')->with(['success' => 'News Category has been deleted successfully']);
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}
