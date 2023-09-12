<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\TranslationCategory;
use App\Models\TranslationKey;
use App\Models\TranslationValue;
use Illuminate\Support\Facades\Artisan;

class TranslationsController extends Controller
{
    public function index()
    {
        $translationCategories = TranslationCategory::with([
            'translationKey'
        ])->get();

        foreach($translationCategories as $key => $val){
            foreach($val->translationKey as $key2 => $val2){
                $english = TranslationValue::where('id_translation_key', $val2->id)
                    ->where('language_code', 'en')
                    ->first();

                $translationCategories[$key]->translationKey[$key2]->english_value = $english->value;
                $translationCategories[$key]->translationKey[$key2]->english_id = $english->id;

                $indonesia = TranslationValue::where('id_translation_key', $val2->id)
                    ->where('language_code', 'id')
                    ->first();

                $translationCategories[$key]->translationKey[$key2]->indonesia_value = $indonesia->value;
                $translationCategories[$key]->translationKey[$key2]->indonesia_id = $indonesia->id;
            }
        }

        return view('backend.pages.settings.translations.index', compact('translationCategories'));
    }

    public function updateValue(Request $request)
    {
        $input = $request->all();

        if(!empty($input['id']) && !empty($input['value'])){
            try {
                DB::beginTransaction();

                $update = TranslationValue::where('id', $input['id'])->update([
                    'value' => $input['value']
                ]);

                DB::commit();

                return response([
                    'success' => true,
                    'code' => 200,
                    'message' => 'Translation successfully updated, please publish your changes'
                ]);
            }catch(Exception $e){
                DB::rollBack();

                return response([
                    'success' => false,
                    'code' => 500,
                    'message' => 'Something went wrong'
                ]);
            }
        }else{
            return response([
                'success' => false,
                'code' => 500,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function publish()
    {
        Artisan::call('translation:publish');

        return response([
            'success' => true,
            'code' => 200,
            'message' => 'Translation successfully published'
        ]);
    }
}
