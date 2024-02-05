<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\HeaderBanner;
use App\Models\HomeVideo;
use App\Models\Product;
use App\Models\HomeMenuSection;
use App\Models\WhyCibesTitle;
use App\Models\WhyCibesUspId;
use App\Models\CompanyVisionId;
use App\Models\TestimonialId;
use App\Models\FormContactUs;

class HomeController extends Controller
{
    public function index()
    {
        $headerBanner = HeaderBanner::with([
            'headerBannerId',
            'headerBannerId.image',
        ])
        ->where('language_code', getLocale())
        ->first();

        $video = HomeVideo::with([
            'video'
        ])
        ->first();

        $products = Product::with([
            'productId',
            'productId.thumbnail'
        ])
        ->where('language_code', getLocale())
        ->whereHas('productId', function($query){
            $query->where('level', 1);
            $query->where('is_active', true);
        })
        ->get();

        $menuSection = HomeMenuSection::with([
            'homeMenuSectionId',
            'homeMenuSectionId.image'
        ])
        ->where('language_code', getLocale())
        ->whereHas('homeMenuSectionId', function($query){
            $query->where('is_active', true);
        })
        ->get();

        $whyCibesTitle = WhyCibesTitle::with([
            'image'
        ])
        ->where('language_code', getLocale())
        ->first();

        $whyCibesUsp = WhyCibesUspId::with([
            'image',
            'whyCibesUsp' => function($query){
                $query->where('language_code', getLocale());
            }
        ])
        ->where('is_active', 1)
        ->orderBy('sort')
        ->get();

        $companyVision = CompanyVisionId::with([
            'image',
            'companyVision' => function($query){
                $query->where('language_code', getLocale());
            }
        ])
        ->where('is_active', 1)
        ->orderBy('sort')
        ->get();

        $testimonial = TestimonialId::with([
            'testimonial' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId',
            'productId.product' => function($query){
                $query->where('language_code', getLocale());
            },
            'productId.specificationImage',
            'image'
        ])->first();

        return view('frontend.pages.home.index', compact('headerBanner', 'video', 'products', 'menuSection', 'whyCibesTitle', 'whyCibesUsp', 'companyVision', 'testimonial'));
    }

    public function formContactUs(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            unset($data['_token']);

            $rules = [
                'name' => ['required'],
                'email' => ['required', 'email'],
                'phone_number' => ['required'],
                'city' => ['required'],
                'number_of_floors' => ['required'],
                'message' => []
            ];

            $messages = [];

            $attributes = [
                'name' => 'name',
                'email' => 'Email',
                'phone_number' => 'Phone Number',
                'city' => 'City',
                'number_of_floors' => 'Jumlah Lantai',
                'message' => 'Pesan'
            ];

            $validator = Validator::make($data, $rules, $messages, $attributes);

            if($validator->fails()){
                return response()->json([
                    'code' => 422,
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'data' => $validator->errors()
                ], 422)
                    ->withHeaders([
                        'Content-Type' => 'application/json'
                    ]);
            }

            $isError = false;

            try{
                DB::beginTransaction();

                $formContactUs = new FormContactUs();

                $formContactUs->fill($data)->save();

                $message = 'Your message has been created successfully';

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
                    'redirect' => urlLocale('')
                ], 200)->withHeaders([
                    'Content-Type' => 'application/json'
                ]);
            }
        }
    }
}
