<?php

namespace App\Http\Controllers\Backend\Content\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\HomeVideo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function index()
    {
        $data = HomeVideo::with([
            'video'
        ])->first();

        if(!empty($data)){
            $data = $data->toArray();
        }

        return view('backend.pages.content.home.video.index', compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        unset($data['_token']);

        $rules = [
            'video' => ['required', 'file'],
        ];

        $messages = [];

        $attributes = [
            'video' => 'Video'
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

            $check = HomeVideo::first();

            if(!empty($check)){
                $homeVideo = $check;
            }else{
                $homeVideo = new HomeVideo();
            }

            $homeVideo->fill([])->save();

            $idHomeVideo = $homeVideo->id;

            $this->storeFile(
                $request->file('video'),
                $homeVideo,
                'video',
                "images/content/home/video/{$idHomeVideo}",
                'video'
            );

            $message = 'Home Video updated successfully';

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
                'redirect' => url('admin-cms/content/home/video')
            ], 200)->withHeaders([
                'Content-Type' => 'application/json'
            ]);
        }
    }
}
