<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductProperty;
use App\Models\ProductPropertyId;
use App\Models\ProductPropertyValue;
use App\Models\ProductPropertyValueId;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class PropertiesController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.pages.products.properties.index');
    }

    public function create()
    {
        $sort = ProductPropertyId::count() + 1;

        return view('backend.pages.products.properties.create', compact('sort'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->post();

        unset($data['_token']);

        $rules = [
            'image' => ['required', 'array', 'file'],
            'sort' => []
        ];

        $messages = [];

        $attributes = [
            'image' => 'Image',
            'sort' => 'Sort',
        ];

        foreach ($request->input as $lang => $input) {
            if($lang == 'id'){
                $rules["input.$lang.name"] = ['required'];
            }else{
                $rules["input.$lang.name"] = [];
            }

            $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

            $attributes["input.$lang.name"] = "$lang_name Name";
        }

        foreach ($request->value as $key => $input) {
            $rules["value.$key.image"] = ['required'];

            $attributes["value.$key.image"] = $key + 1 ." Image";

            foreach ($input as $lang2 => $input2) {
                if($lang == 'id'){
                    $rules["value.$key.input.$lang.name"] = ['required'];
                }else{
                    $rules["value.$key.input.$lang.name"] = [];
                }

                $lang_name = $lang == 'id' ? 'Indonesia' : 'English';

                $attributes["value.$key.input.$lang.name"] = "$lang_name Name";
            }
        }

        $request->validate($rules, $messages, $attributes);

        dd($data);
    }
}
