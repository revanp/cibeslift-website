<?php

namespace App\Http\Controllers\Backend\Content\AboutUs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutUsBannerId;
use App\Models\AboutUsBanner;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $data = AboutUsBannerId::with([
            'image',
            'aboutUsBanner'
        ])
        ->first();

        if(!empty($data)){
            $data = $data->toArray();

            foreach ($data['about_us_banner'] as $key => $val) {
                $data['about_us_banner'][$val['language_code']] = $val;
                unset($data['about_us_banner'][$key]);
            }
        }

        return view('backend.pages.content.about-us.banner.index', compact('data'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'image' => ['required'],
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.title"] = ['required'];
                $rules["input.$lang.description"] = ['required'];
            }else{
                $rules["input.$lang.titl"] = [];
                $rules["input.$lang.description"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.title"] = "$lang_name Title";
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

            $highlightId = AboutUsBannerId::first();
            if(empty($highlightId)){
                $highlightId = new AboutUsBannerId();
            }

            $highlightId->fill([])->save();

            $idHighlightId = $highlightId->id;

            foreach ($data['input'] as $languageCode => $input) {
                $highlight = AboutUsBanner::where('id_about_us_banner_id', $idHighlightId)->where('language_code', $languageCode)->first();
                if(empty($highlight)){
                    $highlight = new AboutUsBanner();
                }

                $input['id_about_us_banner_id'] = $idHighlightId;
                $input['language_code'] = $languageCode;

                if($languageCode != 'id'){
                    $input['title'] = $data['input']['en']['title'] ?? $data['input']['id']['title'];
                    $input['description'] = $data['input']['en']['description'] ?? $data['input']['id']['description'];
                }

                $highlight->fill($input)->save();
            }

            if ($request->hasFile('image')) {
                $this->storeFile(
                    $request->file('image'),
                    $highlightId,
                    'image',
                    "images/about-us/banner/image/{$idHighlightId}",
                    'image'
                );
            }

            $message = 'Banner created successfully';

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
                'redirect' => url('admin-cms/content/about-us/banner')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }
}
