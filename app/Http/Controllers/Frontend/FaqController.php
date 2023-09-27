<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
use App\Models\FaqCategoryId;
use App\Models\Faq;
use App\Models\FaqId;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = FaqCategory::with([
            'faqCategoryId'
        ])
        ->whereHas('faqCategoryId')
        ->where('language_code', getLocale())
        ->get()
        ->toArray();

        foreach($faqs as $key => $val){
            $question = Faq::with([
                'faqId'
            ])
            ->whereHas('faqId', function($data) use ($val){
                $data->where('id_faq_category_id', $val['faq_category_id']['id']);
            })
            ->where('language_code', getLocale())
            ->get()
            ->toArray();

            $faqs[$key]['questions'] = $question;
        }

        return view('frontend.pages.faq.index', compact('faqs'));
    }

}
