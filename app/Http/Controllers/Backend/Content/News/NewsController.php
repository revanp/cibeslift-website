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
    public function index()

    {
        return view('backend.pages.content.news.news.index');
    }

    public function create()
    {
        $categories = NewsCategory::where('language_code', 'id')->get();

        return view('backend.pages.content.news.news.create', compact('categories'));
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

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'thumbnail' => ['required', 'file'],
            'banner' => ['required', 'file'],
            'file_icon' => ['required', 'file'],
            'video_thumbnail' => ['required', 'file'],
            'image' => ['required', 'array'],
            'image.*' => ['file'],
            'video_url' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'thumbnail' => 'Thumbnail',
            'banner' => 'Banner',
            'file_icon' => 'File Icon',
            'video_thumbnail' => 'Video Thumbnail',
            'image' => 'Image',
            'image.*' => 'Image',
            'video_url' => 'Video URL',
            'sort' => 'Sort',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = ['required'];
                $rules["input.$lang.post_description"] = [];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = [];
                $rules["input.$lang.post_description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.post_title"] = "$lang_name Post Title";
            $attributes["input.$lang.post_description"] = "$lang_name Post Description";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $newsId = new NewsId();

            $sort = empty($data['sort']) ? NewsId::count() + 1 : $data['sort'];

            $newsId->fill([
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'is_self_design' => !empty($data['is_self_design']) ? true : false,
                'video_url' => $data['video_url'] ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idNewsId = $newsId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $news = new News();

                $input['id_news_news_id'] = $idNewsId;
                $input['slug'] = Str::slug($input['name']);
                $input['language_code'] = $languageCode;

                $news->fill($input)->save();

                $idNews = $news->id;
            }

            if ($request->hasFile('image')) {
                foreach($request->file('image') as $image){
                    $this->storeFile(
                        $image,
                        $newsId,
                        'image',
                        "images/news/news/image/{$idNewsId}",
                        'image'
                    );
                }
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

            if ($request->hasFile('banner')) {
                $this->storeFile(
                    $request->file('banner'),
                    $newsId,
                    'banner',
                    "images/news/news/banner/{$idNewsId}",
                    'banner'
                );
            }

            if ($request->hasFile('file_icon')) {
                $this->storeFile(
                    $request->file('file_icon'),
                    $newsId,
                    'fileIcon',
                    "images/news/news/file_icon/{$idNewsId}",
                    'file_icon'
                );
            }

            if ($request->hasFile('video_thumbnail')) {
                $this->storeFile(
                    $request->file('video_thumbnail'),
                    $newsId,
                    'videoThumbnail',
                    "images/news/news/video_thumbnail/{$idNewsId}",
                    'video_thumbnail'
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
            return redirect(url('admin-cms/news/news'))
                ->with(['success' => $message]);
        }
    }

    public function edit($id)
    {
        $data = NewsId::with([
            'newsNews',
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

        $sort = NewsId::count() + 1;

        return view('backend.pages.news.news.edit', compact('data', 'sort'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'thumbnail' => ['file'],
            'banner' => ['file'],
            'file_icon' => ['file'],
            'video_thumbnail' => ['file'],
            'image' => ['array'],
            'image.*' => ['file'],
            'video_url' => ['required'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'thumbnail' => 'Thumbnail',
            'banner' => 'Banner',
            'file_icon' => 'File Icon',
            'video_thumbnail' => 'Video Thumbnail',
            'image' => 'Image',
            'image.*' => 'Image',
            'video_url' => 'Video URL',
            'sort' => 'Sort',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = ['required'];
                $rules["input.$lang.post_description"] = [];
            }else{
                $rules["input.$lang.name"] = [];
                $rules["input.$lang.description"] = [];
                $rules["input.$lang.post_title"] = [];
                $rules["input.$lang.post_description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
            $attributes["input.$lang.description"] = "$lang_name Description";
            $attributes["input.$lang.post_title"] = "$lang_name Post Title";
            $attributes["input.$lang.post_description"] = "$lang_name Post Description";
        }

        $request->validate($rules, $messages, $attributes);

        $isError = false;

        try {
            DB::beginTransaction();

            $newsId = NewsId::find($id);

            $sort = empty($data['sort']) ? NewsId::count() + 1 : $data['sort'];

            $newsId->fill([
                'sort' => $sort,
                'is_active' => !empty($data['is_active']) ? true : false,
                'is_self_design' => !empty($data['is_self_design']) ? true : false,
                'video_url' => $data['video_url'] ?? null,
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_by' => 0,
            ])->save();

            $idNewsId = $newsId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $news = News::where('id_news_news_id', $id)->where('language_code', $languageCode)->first();

                $input['id_news_news_id'] = $idNewsId;
                $input['slug'] = Str::slug($input['name']);
                $input['language_code'] = $languageCode;

                $news->fill($input)->save();

                $idNews = $news->id;
            }

            if ($request->hasFile('image')) {
                foreach($request->file('image') as $key => $image){
                    if(!empty($data['image_id'][$key])){
                        $deleteImage = Media::where('id', $data['image_id'][$key])->delete();
                    }

                    $this->storeFile(
                        $image,
                        $newsId,
                        'image',
                        "images/news/news/image/{$idNewsId}",
                        'image'
                    );
                }
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

            if ($request->hasFile('banner')) {
                $this->storeFile(
                    $request->file('banner'),
                    $newsId,
                    'banner',
                    "images/news/news/banner/{$idNewsId}",
                    'banner'
                );
            }

            if ($request->hasFile('file_icon')) {
                $this->storeFile(
                    $request->file('file_icon'),
                    $newsId,
                    'fileIcon',
                    "images/news/news/file_icon/{$idNewsId}",
                    'file_icon'
                );
            }

            if ($request->hasFile('video_thumbnail')) {
                $this->storeFile(
                    $request->file('video_thumbnail'),
                    $newsId,
                    'videoThumbnail',
                    "images/news/news/video_thumbnail/{$idNewsId}",
                    'video_thumbnail'
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
            return redirect(url('admin-cms/news/news'))
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



