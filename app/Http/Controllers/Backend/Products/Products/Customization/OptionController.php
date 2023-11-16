<?php

namespace App\Http\Controllers\Backend\Products\Products\Customization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductId;
use App\Models\ProductCustomization;
use App\Models\ProductCustomizationId;
use App\Models\ProductCustomizationFeature;
use App\Models\ProductCustomizationFeatureId;
use App\Models\ProductCustomizationOption;
use App\Models\ProductCustomizationOptionId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Exception;
use Illuminate\Support\Str;

class OptionController extends Controller
{
    public function __construct(Request $request)
    {
        $id = $request->route()->parameter('id');

        $check = ProductId::find($id);
        if(empty($check)){
            abort(404);
        }

        $idCustomization = $request->route()->parameter('idCustomization');

        $check2 = ProductCustomizationId::find($idCustomization);
        if(empty($check2)){
            abort(404);
        }
    }

    public function index($id, $idCustomization)
    {
        $datas = ProductCustomizationOption::with(['productCustomizationOptionId'])
            ->where('language_code', 'id')
            ->whereHas('productCustomizationOptionId', function($query) use($idCustomization){
                $query->where('id_product_customization_id', $idCustomization);
            })
            ->get();

        return view('backend.pages.products.products.customizations.options.index', compact('id', 'idCustomization', 'datas'));
    }

    public function create($id, $idCustomization)
    {
        return view('backend.pages.products.products.customizations.options.create', compact('id', 'idCustomization'));
    }
}
