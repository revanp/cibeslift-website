<?php

namespace App\Http\Controllers\Backend\Content\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategoryId;
use App\Models\NewsCategory;
use App\Models\NewsId;
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

    public function store(Request $request)
    {
        $user = Auth ::user();
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

            $newsId = new NewsId();

            $newsId->fill([
                'is_active' => true
            ])->save();

            $idNewsId = $newsId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $news = new News();

                $input['id_news_id'] = $idNewsId;
                $input['language_code'] = $languageCode;
                $input['created_by'] = $user->id;
                $input['updated_by'] = $user->id;
                $input['deleted_by'] = 0;

                $news->fill($input)->save();

                $idNewsController = $news->id;
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
            return redirect(url('admin-cms/content/news/categories'))
                ->with(['success' => $message]);
        }
    }

    public function edit($id)
    {
        $newsId = NewsId::find($id);

        $news = NewsController::where('id_news_id', $id)
            ->get()
            ->toArray();

        foreach ($news as $key => $val) {
            $news[$val['language_code']] = $val;
            unset($news[$key]);
        }

        return view('backend.pages.content.news.controller.edit', compact('NewsId', 'newsController'));
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

            $newsId = NewsId::find($id);

            $newsId->fill([
                'is_active' => true
            ])->save();

            $idNewsId = $newsId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $news = NewsController::where('id_news_id', $id)->first();

                $input['id_news_id'] = $idNewsId;
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

