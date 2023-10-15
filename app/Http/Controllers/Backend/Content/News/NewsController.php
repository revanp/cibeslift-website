<?php

namespace App\Http\Controllers\Backend\Content\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategoryId;
use App\Models\NewsCategory;
use App\Models\NewsId;
use App\Models\Media;
use App\Models\News;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $reqDatatable  = $this->requestDatatables($request->input());

            $data = News::with([
                'NewsId',
                'NewsId.NewsCategoryId',
                'NewsId.NewsCategoryId.NewsCategory' => function($query){
                    $query->where('language_code', 'id');
                },
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
                ->addColumn('category', function($data){
                    return $data->NewsId->newsCategoryId->newsCategory[0]->name;
                })
                ->addColumn('publish_date', function($data){
                    return date('Y-m-d', strtotime($data->NewsId->publish_date));
                })
                ->addColumn('is_active', function($data){
                    $id = $data->NewsId->id;
                    $isActive = $data->NewsId->is_active;

                    return view('backend.pages.content.news.news.list.active', compact('id', 'isActive'));
                })
                ->addColumn('action', function($data){
                    $html = '<div class="dropdown dropdown-inline mr-1"><a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"><i class="flaticon2-menu-1 icon-2x"></i></a><div class="dropdown-menu dropdown-menu-sm dropdown-menu-right"><ul class="nav nav-hoverable flex-column">';
                        //* EDIT
                        $html .= '<li class="nav-item"><a class="nav-link" href="'. url('admin-cms/content/news/news/edit/'.$data->NewsId->id) .'"><i class="flaticon2-edit nav-icon"></i><span class="nav-text">Edit</span></a></li>';

                        //* DELETE
                        $html .= '<li class="nav-item"><a class="nav-link btn-delete" href="'. url('admin-cms/content/news/news/delete/'.$data->NewsId->id) .'"><i class="flaticon2-delete nav-icon"></i><span class="nav-text">Delete</span></a></li>';
                    $html .= '</ul></div></div>';

                    return $html;
                })
                ->rawColumns(['image', 'action'])
                ->toJson(true);
        }

        return view('backend.pages.content.news.news.index');
    }

    public function view($id)
    {
        $data = NewsId::with([
            'news',
            'image',
            'thumbnail',
            'banner',
            'fileIcon',
            'videoThumbnail',
        ])
        ->find($id)
        ->toArray();

        foreach ($data['news_news'] as $key => $val) {
            $data['news_news'][$val['language_code']] = $val;
            unset($data['news_news'][$key]);
        }

        return view('backend.pages.news.news.view', compact('data'));
    }

    public function create()
    {
        $categories = NewsCategory::where('language_code', 'id')->get();

        return view('backend.pages.content.news.news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'id_news_category_id' => ['required'],
            'thumbnail' => ['required', 'file'],
            'publish_date' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'id_news_category_id' => 'News Category',
            'thumbnail' => 'Thumbnail',
            'publish_date' => 'Publish Date',
            'sort' => 'Sort',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
                $rules["input.$lang.content"] = ['required'];
                $rules["input.$lang.seo_title"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.content"] = [];
                $rules["input.$lang.seo_title"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.content"] = "$lang_name Content";
            $attributes["input.$lang.seo_title"] = "$lang_name SEO Title";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $newsId = new NewsId();

            $newsId->fill([
                'sort' => 0,
                'id_news_category_id' => $data['id_news_category_id'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'is_top' => !empty($data['is_top']) ? true : false,
                'is_home' => !empty($data['is_home']) ? true : false,
                'publish_date' => $data['publish_date'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idNewsId = $newsId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $news = new News();

                $input['id_news_id'] = $idNewsId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                    $input['content'] = $data['input']['en']['content'] ?? $data['input']['id']['content'];
                    $input['seo_title'] = $data['input']['en']['seo_title'] ?? $data['input']['id']['seo_title'];
                    $input['seo_description'] = $data['input']['en']['seo_description'] ?? $data['input']['id']['seo_description'];
                    $input['seo_keyword'] = $data['input']['en']['seo_keyword'] ?? $data['input']['id']['seo_keyword'];
                    $input['seo_canonical_url'] = $data['input']['en']['seo_canonical_url'] ?? $data['input']['id']['seo_canonical_url'];
                }

                $input['slug'] = Str::slug($input['title']);

                $news->fill($input)->save();

                $idNews = $news->id;
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $newsId,
                    'thumbnail',
                    "images/news/news/thumbnail/{$idNewsId}",
                    'thumbnail'
                );
            }

            $message = 'News created successfully';

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
            return redirect(url('admin-cms/content/news/news'))
                ->with(['success' => $message]);
        }
    }

    public function edit($id)
    {
        $data = NewsId::with([
            'news',
            'thumbnail',
        ])
        ->find($id)
        ->toArray();

        foreach ($data['news'] as $key => $val) {
            $data['news'][$val['language_code']] = $val;
            unset($data['news'][$key]);
        }

        $categories = NewsCategory::where('language_code', 'id')->get();

        return view('backend.pages.content.news.news.edit', compact('data', 'categories'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'id_news_category_id' => ['required'],
            'thumbnail' => ['file'],
            'publish_date' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'id_news_category_id' => 'News Category',
            'thumbnail' => 'Thumbnail',
            'publish_date' => 'Publish Date',
            'sort' => 'Sort',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
                $rules["input.$lang.content"] = ['required'];
                $rules["input.$lang.seo_title"] = ['required'];
            }else{
                $rules["input.$lang.title"] = [];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.content"] = [];
                $rules["input.$lang.seo_title"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.content"] = "$lang_name Content";
            $attributes["input.$lang.seo_title"] = "$lang_name SEO Title";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $newsId = NewsId::find($id);

            $newsId->fill([
                'sort' => 0,
                'id_news_category_id' => $data['id_news_category_id'],
                'is_active' => !empty($data['is_active']) ? true : false,
                'is_top' => !empty($data['is_top']) ? true : false,
                'is_home' => !empty($data['is_home']) ? true : false,
                'publish_date' => $data['publish_date'],
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idNewsId = $newsId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $news = News::where('id_news_id', $id)->where('language_code', $languageCode)->first();

                $input['id_news_id'] = $idNewsId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                    $input['content'] = $data['input']['en']['content'] ?? $data['input']['id']['content'];
                    $input['seo_title'] = $data['input']['en']['seo_title'] ?? $data['input']['id']['seo_title'];
                    $input['seo_description'] = $data['input']['en']['seo_description'] ?? $data['input']['id']['seo_description'];
                    $input['seo_keyword'] = $data['input']['en']['seo_keyword'] ?? $data['input']['id']['seo_keyword'];
                    $input['seo_canonical_url'] = $data['input']['en']['seo_canonical_url'] ?? $data['input']['id']['seo_canonical_url'];
                }

                $input['slug'] = Str::slug($input['title']);

                $news->fill($input)->save();

                $idNews = $news->id;
            }

            if ($request->hasFile('thumbnail')) {
                $this->storeFile(
                    $request->file('thumbnail'),
                    $newsId,
                    'thumbnail',
                    "images/news/news/thumbnail/{$idNewsId}",
                    'thumbnail'
                );
            }

            $message = 'News updated successfully';

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
            return redirect(url('admin-cms/content/news/news'))
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

                $update = NewsId::where('id', $id)->update([
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

            $delete = NewsId::where('id', $id)->update([
                'deleted_by' => Auth::user()->id,
                'deleted_at' => date('Y-m-d H:i:s')
            ]);

            $deleteChild = News::where('id_news_news_id', $id)->delete();

            DB::commit();

            return redirect('admin-cms/news/news')->with(['success' => 'News has been deleted successfully']);
        }catch(Exception $e){
            DB::rollBack();

            return redirect()->back()->with(['error' => 'Something went wrong, please try again']);
        }
    }
}



